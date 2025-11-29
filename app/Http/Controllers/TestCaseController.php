<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TestCase;
use Illuminate\Http\Request;

class TestCaseController extends Controller
{
    public function index(Project $project)
    {
        $testCases = $project->testCases()
            ->with(['testSuite', 'creator', 'assignedUser', 'tags'])
            ->when(request('search'), function($q, $search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->when(request('priority'), function($q, $priority) {
                $q->where('priority', $priority);
            })
            ->when(request('status'), function($q, $status) {
                $q->where('status', $status);
            })
            ->when(request('suite'), function($q, $suite) {
                $q->where('test_suite_id', $suite);
            })
            ->latest()
            ->paginate(20);

        $testSuites = $project->testSuites;

        return view('test-cases.index', compact('project', 'testCases', 'testSuites'));
    }

    public function create(Project $project)
    {
        $testSuites = $project->testSuites;
        return view('test-cases.create', compact('project', 'testSuites'));
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'test_suite_id' => 'nullable|exists:test_suites,id',
            'preconditions' => 'nullable|string',
            'steps' => 'required|array',
            'steps.*.action' => 'required|string',
            'steps.*.expected' => 'nullable|string',
            'expected_result' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
            'type' => 'required|in:functional,integration,regression,smoke,sanity,ui,api',
            'automated' => 'required|in:yes,no,partial',
            'estimated_time' => 'nullable|integer|min:1',
        ]);

        $validated['project_id'] = $project->id;
        $validated['created_by'] = auth()->id();

        $testCase = TestCase::create($validated);

        return redirect()->route('projects.test-cases.show', [$project, $testCase])
            ->with('success', 'Test case created successfully!');
    }

    public function show(Project $project, TestCase $testCase)
    {
        $testCase->load(['testSuite', 'creator', 'assignedUser', 'tags', 'attachments', 'executions.testRun']);

        return view('test-cases.show', compact('project', 'testCase'));
    }

    public function edit(Project $project, TestCase $testCase)
    {
        $testSuites = $project->testSuites;
        return view('test-cases.edit', compact('project', 'testCase', 'testSuites'));
    }

    public function update(Request $request, Project $project, TestCase $testCase)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'test_suite_id' => 'nullable|exists:test_suites,id',
            'preconditions' => 'nullable|string',
            'steps' => 'required|array',
            'expected_result' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
            'type' => 'required|in:functional,integration,regression,smoke,sanity,ui,api',
            'status' => 'required|in:draft,ready,deprecated',
            'automated' => 'required|in:yes,no,partial',
            'estimated_time' => 'nullable|integer|min:1',
        ]);

        $testCase->update($validated);

        return redirect()->route('projects.test-cases.show', [$project, $testCase])
            ->with('success', 'Test case updated successfully!');
    }

    public function destroy(Project $project, TestCase $testCase)
    {
        $testCase->delete();

        return redirect()->route('projects.test-cases.index', $project)
            ->with('success', 'Test case deleted successfully!');
    }
}