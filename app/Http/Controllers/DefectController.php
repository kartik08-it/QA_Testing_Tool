<?php

// app/Http/Controllers/DefectController.php
namespace App\Http\Controllers;

use App\Models\Defect;
use App\Models\Project;
use Illuminate\Http\Request;

class DefectController extends Controller
{
    public function index(Project $project)
    {
        $defects = $project->defects()
            ->with(['reporter', 'assignee', 'testExecution'])
            ->when(request('status'), function($q, $status) {
                $q->where('status', $status);
            })
            ->when(request('severity'), function($q, $severity) {
                $q->where('severity', $severity);
            })
            ->latest()
            ->paginate(20);

        return view('defects.index', compact('project', 'defects'));
    }

    public function create(Project $project)
    {
        return view('defects.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'steps_to_reproduce' => 'nullable|string',
            'severity' => 'required|in:low,medium,high,critical',
            'priority' => 'required|in:low,medium,high,critical',
            'environment' => 'nullable|string',
        ]);

        $validated['project_id'] = $project->id;
        $validated['reported_by'] = auth()->id();
        $validated['status'] = 'open';

        $defect = Defect::create($validated);

        return redirect()->route('projects.defects.show', [$project, $defect])
            ->with('success', 'Defect created successfully!');
    }

    public function show(Project $project, Defect $defect)
    {
        $defect->load(['reporter', 'assignee', 'testExecution', 'attachments']);
        return view('defects.show', compact('project', 'defect'));
    }

    public function updateStatus(Request $request, Project $project, Defect $defect)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed,reopened',
        ]);

        $defect->update(['status' => $request->status]);

        return back()->with('success', 'Defect status updated successfully!');
    }
}