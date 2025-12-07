<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Test Execution Report - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.reports.index', $project) }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Reports
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Recent Test Runs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Test Runs (Last 10)</h3>
                    
                    @if($testRuns->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Test Run</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Passed</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Failed</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pass Rate</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($testRuns as $run)
                                        @php
                                            $counts = $run->statusCounts;
                                            $total = array_sum($counts);
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <a href="{{ route('projects.test-runs.show', [$project, $run]) }}" 
                                                   class="text-blue-600 hover:text-blue-900 font-medium">
                                                    {{ $run->name }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'planned' => 'bg-gray-100 text-gray-800',
                                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                                        'completed' => 'bg-green-100 text-green-800',
                                                        'aborted' => 'bg-red-100 text-red-800'
                                                    ];
                                                @endphp
                                                <span class="px-2 py-1 text-xs rounded {{ $statusColors[$run->status] }}">
                                                    {{ ucfirst(str_replace('_', ' ', $run->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm">{{ $total }}</td>
                                            <td class="px-6 py-4 text-sm text-green-600 font-medium">{{ $counts['passed'] }}</td>
                                            <td class="px-6 py-4 text-sm text-red-600 font-medium">{{ $counts['failed'] }}</td>
                                            <td class="px-6 py-4 text-sm font-bold">{{ $run->passRate }}%</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $run->created_at->format('M d, Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8">No test runs available yet.</p>
                    @endif
                </div>
            </div>

            <!-- Execution Trends -->
            @if($executionTrends->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Execution Trends (Last 30 Days)</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Executed</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Passed</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Failed</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pass Rate</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($executionTrends as $trend)
                                        @php
                                            $passRate = $trend->total > 0 ? round(($trend->passed / $trend->total) * 100, 1) : 0;
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-sm font-medium">
                                                {{ \Carbon\Carbon::parse($trend->date)->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm">{{ $trend->total }}</td>
                                            <td class="px-6 py-4 text-sm text-green-600 font-medium">{{ $trend->passed }}</td>
                                            <td class="px-6 py-4 text-sm text-red-600 font-medium">{{ $trend->failed }}</td>
                                            <td class="px-6 py-4 text-sm font-bold">{{ $passRate }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
