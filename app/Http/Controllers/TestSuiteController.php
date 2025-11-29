<?php
namespace App\Http\Controllers;

use App\Models\TestSuite;
use App\Models\Project;
use Illuminate\Http\Request;

class TestSuiteController extends Controller
{
    public function index(Project $project)
    {
        $testSuites = $project->testSuites()
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        return view('test-suites.index', compact('project', 'testSuites'));
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:test_suites,id',
        ]);

        $validated['project_id'] = $project->id;
        $suite = TestSuite::create($validated);

        return back()->with('success', 'Test suite created successfully!');
    }
}
