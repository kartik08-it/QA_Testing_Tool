<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Defect #{{ $defect->id }}: {{ $defect->title }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $project->name }}</p>
            </div>
            <a href="{{ route('projects.defects.index', $project) }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Main Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    
                    <!-- Status Update -->
                    <div class="mb-6 pb-6 border-b">
                        <h3 class="font-semibold text-lg mb-3">Update Status</h3>
                        <form action="{{ route('projects.defects.update-status', [$project, $defect]) }}" method="POST" class="flex gap-3">
                            @csrf
                            <select name="status" class="border border-gray-300 rounded-lg px-4 py-2">
                                <option value="open" {{ $defect->status === 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ $defect->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $defect->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ $defect->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="reopened" {{ $defect->status === 'reopened' ? 'selected' : '' }}>Reopened</option>
                            </select>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                                Update Status
                            </button>
                        </form>
                    </div>

                    <!-- Defect Info -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <div class="text-sm text-gray-500">Severity</div>
                            @php
                                $severityColors = [
                                    'low' => 'bg-gray-100 text-gray-800',
                                    'medium' => 'bg-yellow-100 text-yellow-800',
                                    'high' => 'bg-orange-100 text-orange-800',
                                    'critical' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-block mt-1 px-3 py-1 text-sm rounded {{ $severityColors[$defect->severity] }}">
                                {{ ucfirst($defect->severity) }}
                            </span>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Priority</div>
                            @php
                                $priorityColors = [
                                    'low' => 'bg-gray-100 text-gray-800',
                                    'medium' => 'bg-yellow-100 text-yellow-800',
                                    'high' => 'bg-orange-100 text-orange-800',
                                    'critical' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-block mt-1 px-3 py-1 text-sm rounded {{ $priorityColors[$defect->priority] }}">
                                {{ ucfirst($defect->priority) }}
                            </span>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Status</div>
                            @php
                                $statusColors = [
                                    'open' => 'bg-red-100 text-red-800',
                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                    'resolved' => 'bg-green-100 text-green-800',
                                    'closed' => 'bg-gray-100 text-gray-800',
                                    'reopened' => 'bg-orange-100 text-orange-800'
                                ];
                            @endphp
                            <span class="inline-block mt-1 px-3 py-1 text-sm rounded {{ $statusColors[$defect->status] }}">
                                {{ ucfirst(str_replace('_', ' ', $defect->status)) }}
                            </span>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Environment</div>
                            <div class="mt-1 font-medium">{{ $defect->environment ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-2">Description</h3>
                        <p class="text-gray-700">{{ $defect->description }}</p>
                    </div>

                    @if($defect->steps_to_reproduce)
                        <div class="mb-6">
                            <h3 class="font-semibold text-lg mb-2">Steps to Reproduce</h3>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <pre class="text-gray-700 whitespace-pre-wrap">{{ $defect->steps_to_reproduce }}</pre>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-6 text-sm">
                        <div>
                            <div class="text-gray-500">Reported By</div>
                            <div class="font-medium">{{ $defect->reporter->name }}</div>
                            <div class="text-xs text-gray-500">{{ $defect->created_at->format('M d, Y H:i') }}</div>
                        </div>
                        
                        <div>
                            <div class="text-gray-500">Assigned To</div>
                            <div class="font-medium">{{ $defect->assignee?->name ?? 'Unassigned' }}</div>
                        </div>
                    </div>

                    @if($defect->testExecution)
                        <div class="mt-6 pt-6 border-t">
                            <h3 class="font-semibold text-lg mb-2">Related Test Execution</h3>
                            <a href="{{ route('projects.test-runs.show', [$project, $defect->testExecution->testRun]) }}" 
                               class="text-blue-600 hover:text-blue-900">
                                Test Run: {{ $defect->testExecution->testRun->name }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>