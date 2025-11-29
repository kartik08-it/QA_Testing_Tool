<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Total Projects</div>
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['total_projects'] }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Test Cases</div>
                    <div class="text-3xl font-bold text-green-600">{{ $stats['total_test_cases'] }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Test Runs</div>
                    <div class="text-3xl font-bold text-purple-600">{{ $stats['total_test_runs'] }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">Open Defects</div>
                    <div class="text-3xl font-bold text-red-600">{{ $stats['open_defects'] }}</div>
                </div>
            </div>

            <!-- Recent Activity & Charts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Recent Test Runs -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Recent Test Runs</h3>
                        
                        @if($recentRuns->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentRuns as $run)
                                    <div class="border-l-4 border-blue-500 pl-4">
                                        <div class="font-semibold">{{ $run->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $run->project->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $run->created_at->diffForHumans() }}</div>
                                        <div class="mt-2">
                                            @php
                                                $counts = $run->statusCounts;
                                                $total = array_sum($counts);
                                            @endphp
                                            <div class="flex gap-2 text-xs">
                                                <span class="text-green-600">✓ {{ $counts['passed'] }}</span>
                                                <span class="text-red-600">✗ {{ $counts['failed'] }}</span>
                                                <span class="text-yellow-600">⊘ {{ $counts['blocked'] }}</span>
                                                <span class="text-gray-600">○ {{ $counts['pending'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">No test runs yet</p>
                        @endif
                    </div>
                </div>

                <!-- Defects by Severity -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Open Defects by Severity</h3>
                        
                        @if($defectsBySeverity->count() > 0)
                            <div class="space-y-3">
                                @foreach(['critical' => 'red', 'high' => 'orange', 'medium' => 'yellow', 'low' => 'blue'] as $severity => $color)
                                    @php
                                        $count = $defectsBySeverity[$severity] ?? 0;
                                        $total = $defectsBySeverity->sum();
                                        $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                                    @endphp
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium capitalize">{{ $severity }}</span>
                                            <span class="text-sm text-gray-600">{{ $count }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-{{ $color }}-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">No open defects</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Projects List -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Your Projects</h3>
                        <a href="{{ route('projects.create') }}" class="text-blue-500 hover:text-blue-700">
                            + New Project
                        </a>
                    </div>

                    @if($projects->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Project</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Key</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Test Cases</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Test Runs</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Defects</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($projects as $project)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="font-medium text-gray-900">{{ $project->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">
                                                    {{ $project->key }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $project->testCases->count() }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $project->testRuns->count() }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $project->defects->whereIn('status', ['open', 'in_progress'])->count() }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded capitalize">
                                                    {{ $project->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-900">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">
                            No projects yet. <a href="{{ route('projects.create') }}" class="text-blue-500 hover:text-blue-700">Create your first project</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>