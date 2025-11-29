<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TestExecution;
use App\Models\TestRun;
use Illuminate\Http\Request;

class TestRunController extends Controller
{
    public function index(Project $project)
    {
        $testRuns = $project->testRuns()
            ->with('creator')
            ->latest()
            ->paginate(15);

        return view('test-runs.index', compact('project', 'testRuns'));
    }

    public function create(Project $project)
    {
        $testCases = $project->testCases()->where('status', 'ready')->get();
        return view('test-runs.create', compact('project', 'testCases'));
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'environment' => 'nullable|string',
            'build_version' => 'nullable|string',
            'test_cases' => 'required|array',
            'test_cases.*' => 'exists:test_cases,id',
        ]);

        $validated['project_id'] = $project->id;
        $validated['created_by'] = auth()->id();
        $validated['status'] = 'planned';

        $testRun = TestRun::create($validated);

        // Create test executions for selected test cases
        foreach ($request->test_cases as $testCaseId) {
            $testRun->executions()->create([
                'test_case_id' => $testCaseId,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('projects.test-runs.show', [$project, $testRun])
            ->with('success', 'Test run created successfully!');
    }

    public function show(Project $project, TestRun $testRun)
    {
        $testRun->load(['executions.testCase', 'executions.executor']);

        return view('test-runs.show', compact('project', 'testRun'));
    }

    public function execute(Project $project, TestRun $testRun)
    {
        if ($testRun->status === 'planned') {
            $testRun->update([
                'status' => 'in_progress',
                'started_at' => now(),
            ]);
        }

        $execution = $testRun->executions()
            ->with('testCase')
            ->where('status', 'pending')
            ->first();

        if (!$execution) {
            return redirect()->route('projects.test-runs.show', [$project, $testRun])
                ->with('info', 'All test cases have been executed!');
        }

        return view('test-runs.execute', compact('project', 'testRun', 'execution'));
    }

    public function updateExecution(Request $request, Project $project, TestRun $testRun, TestExecution $execution)
    {
        $validated = $request->validate([
            'status' => 'required|in:passed,failed,blocked,skipped',
            'actual_result' => 'nullable|string',
            'comments' => 'nullable|string',
            'execution_time' => 'nullable|integer|min:1',
        ]);

        $validated['executed_by'] = auth()->id();
        $validated['executed_at'] = now();

        $execution->update($validated);

        // Check if all executions are complete
        $pending = $testRun->executions()->where('status', 'pending')->count();
        if ($pending === 0) {
            $testRun->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        }

        return redirect()->route('projects.test-runs.execute', [$project, $testRun])
            ->with('success', 'Test execution updated successfully!');
    }
}
