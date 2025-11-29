<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $projects = Project::with('creator')
            ->accessibleBy(auth()->id())
            ->latest()
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:10|unique:projects,key|alpha_dash',
            'description' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['key'] = strtoupper($validated['key']);
        $validated['status'] = 'active';

        $project = Project::create($validated);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        // Check if user has access
        if ($project->created_by !== auth()->id() && !$project->hasMember(auth()->id())) {
            abort(403, 'You do not have access to this project.');
        }

        $project->load(['testSuites', 'testCases', 'testRuns']);
        
        $stats = [
            'total_cases' => $project->testCases()->count(),
            'ready_cases' => $project->testCases()->where('status', 'ready')->count(),
            'total_runs' => $project->testRuns()->count(),
            'completed_runs' => $project->testRuns()->where('status', 'completed')->count(),
            'total_defects' => $project->defects()->count(),
            'active_defects' => $project->defects()->whereIn('status', ['open', 'in_progress'])->count(),
        ];

        return view('projects.show', compact('project', 'stats'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        // Check if user is the creator
        if ($project->created_by !== auth()->id()) {
            abort(403, 'Only the project creator can edit the project.');
        }

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        // Check if user is the creator
        if ($project->created_by !== auth()->id()) {
            abort(403, 'Only the project creator can update the project.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,archived',
        ]);

        $project->update($validated);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        // Check if user is the creator
        if ($project->created_by !== auth()->id()) {
            abort(403, 'Only the project creator can delete the project.');
        }

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully!');
    }
}