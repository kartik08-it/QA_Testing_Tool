<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Defects - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.defects.create', $project) }}" 
               class="bg-red-500 hover:bg-red-700 text-black font-bold py-2 px-4 rounded">
                + Report Defect
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                <option value="">All Statuses</option>
                                <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="reopened" {{ request('status') === 'reopened' ? 'selected' : '' }}>Reopened</option>
                            </select>
                        </div>
                        
                        <div>
                            <select name="severity" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                <option value="">All Severities</option>
                                <option value="low" {{ request('severity') === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ request('severity') === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ request('severity') === 'high' ? 'selected' : '' }}>High</option>
                                <option value="critical" {{ request('severity') === 'critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                        </div>
                        
                        <div class="flex gap-2">
                            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-black font-bold py-2 px-4 rounded flex-1">
                                Filter
                            </button>
                            <a href="{{ route('projects.defects.index', $project) }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Defects List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($defects->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Severity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reported By</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned To</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($defects as $defect)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                #{{ $defect->id }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-900">{{ $defect->title }}</div>
                                                <div class="text-sm text-gray-500">{{ Str::limit($defect->description, 60) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $severityColors = [
                                                        'low' => 'bg-gray-100 text-gray-800',
                                                        'medium' => 'bg-yellow-100 text-yellow-800',
                                                        'high' => 'bg-orange-100 text-orange-800',
                                                        'critical' => 'bg-red-100 text-red-800'
                                                    ];
                                                @endphp
                                                <span class="px-2 py-1 text-xs rounded {{ $severityColors[$defect->severity] }}">
                                                    {{ ucfirst($defect->severity) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $priorityColors = [
                                                        'low' => 'bg-gray-100 text-gray-800',
                                                        'medium' => 'bg-yellow-100 text-yellow-800',
                                                        'high' => 'bg-orange-100 text-orange-800',
                                                        'critical' => 'bg-red-100 text-red-800'
                                                    ];
                                                @endphp
                                                <span class="px-2 py-1 text-xs rounded {{ $priorityColors[$defect->priority] }}">
                                                    {{ ucfirst($defect->priority) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'open' => 'bg-red-100 text-red-800',
                                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                                        'resolved' => 'bg-green-100 text-green-800',
                                                        'closed' => 'bg-gray-100 text-gray-800',
                                                        'reopened' => 'bg-orange-100 text-orange-800'
                                                    ];
                                                @endphp
                                                <span class="px-2 py-1 text-xs rounded {{ $statusColors[$defect->status] }}">
                                                    {{ ucfirst(str_replace('_', ' ', $defect->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $defect->reporter->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $defect->assignee?->name ?? 'Unassigned' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('projects.defects.show', [$project, $defect]) }}" 
                                                   class="text-blue-600 hover:text-blue-900">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $defects->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-500 mt-4 mb-4">No defects reported yet.</p>
                            <a href="{{ route('projects.defects.create', $project) }}" 
                               class="bg-red-500 hover:bg-red-700 text-black font-bold py-2 px-4 rounded">
                                + Report First Defect
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
