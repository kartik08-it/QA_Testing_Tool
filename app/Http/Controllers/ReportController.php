<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Project $project)
    {
        return view('reports.index', compact('project'));
    }

    public function coverage(Project $project)
    {
        $totalCases = $project->testCases()->count();
        $executedCases = $project->testCases()
            ->whereHas('executions')
            ->count();

        $coverageByPriority = $project->testCases()
            ->select('priority', 
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(DISTINCT CASE WHEN EXISTS(
                    SELECT 1 FROM test_executions 
                    WHERE test_executions.test_case_id = test_cases.id
                ) THEN test_cases.id END) as executed')
            )
            ->groupBy('priority')
            ->get();

        return view('reports.coverage', compact('project', 'totalCases', 'executedCases', 'coverageByPriority'));
    }

   public function execution(Project $project)
{
    $testRuns = $project->testRuns()
        ->with('executions')
        ->latest()
        ->limit(10)
        ->get();

    // FIXED QUERY - specify table name for status column
    $executionTrends = DB::table('test_executions')
        ->join('test_runs', 'test_executions.test_run_id', '=', 'test_runs.id')
        ->where('test_runs.project_id', $project->id)
        ->where('test_executions.executed_at', '>=', now()->subDays(30))
        ->select(
            DB::raw('DATE(test_executions.executed_at) as date'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN test_executions.status = "passed" THEN 1 ELSE 0 END) as passed'),
            DB::raw('SUM(CASE WHEN test_executions.status = "failed" THEN 1 ELSE 0 END) as failed')
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    return view('reports.execution', compact('project', 'testRuns', 'executionTrends'));
}

    public function defects(Project $project)
    {
        $defectStats = [
            'total' => $project->defects()->count(),
            'open' => $project->defects()->where('status', 'open')->count(),
            'in_progress' => $project->defects()->where('status', 'in_progress')->count(),
            'resolved' => $project->defects()->where('status', 'resolved')->count(),
            'closed' => $project->defects()->where('status', 'closed')->count(),
        ];

        $defectsBySeverity = $project->defects()
            ->select('severity', DB::raw('COUNT(*) as count'))
            ->groupBy('severity')
            ->pluck('count', 'severity');

        $defectTrends = DB::table('defects')
            ->where('project_id', $project->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('reports.defects', compact('project', 'defectStats', 'defectsBySeverity', 'defectTrends'));
    }
}