<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TestCase;
use App\Models\TestRun;
use App\Models\Defect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    $userId = auth()->id();

    // Get user's projects
    $projects = Project::where('created_by', $userId)
        ->orWhereHas('members', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->with(['testCases', 'testRuns', 'defects'])
        ->get();

    // Overall statistics
    $stats = [
        'total_projects' => $projects->count(),
        'total_test_cases' => TestCase::whereIn('project_id', $projects->pluck('id'))->count(),
        'total_test_runs' => TestRun::whereIn('project_id', $projects->pluck('id'))->count(),
        'open_defects' => Defect::whereIn('project_id', $projects->pluck('id'))
            ->whereIn('status', ['open', 'in_progress'])
            ->count(),
    ];

    // Recent test runs
    $recentRuns = TestRun::whereIn('project_id', $projects->pluck('id'))
        ->with('project')
        ->latest()
        ->limit(5)
        ->get();

    // Test execution trends (last 7 days) - FIXED QUERY
    $executionTrends = DB::table('test_executions')
        ->join('test_runs', 'test_executions.test_run_id', '=', 'test_runs.id')
        ->whereIn('test_runs.project_id', $projects->pluck('id'))
        ->where('test_executions.executed_at', '>=', now()->subDays(7))
        ->select(
            DB::raw('DATE(test_executions.executed_at) as date'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN test_executions.status = "passed" THEN 1 ELSE 0 END) as passed'),
            DB::raw('SUM(CASE WHEN test_executions.status = "failed" THEN 1 ELSE 0 END) as failed')
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // Active defects by severity
    $defectsBySeverity = Defect::whereIn('project_id', $projects->pluck('id'))
        ->whereIn('status', ['open', 'in_progress'])
        ->select('severity', DB::raw('count(*) as count'))
        ->groupBy('severity')
        ->pluck('count', 'severity');

    return view('dashboard', compact('stats', 'projects', 'recentRuns', 'executionTrends', 'defectsBySeverity'));
}
}
