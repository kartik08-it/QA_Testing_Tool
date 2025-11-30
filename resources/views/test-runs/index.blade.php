<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Test Runs - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.test-runs.create', $project) }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Create Test Run
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($testRuns->count() > 0)
                        <div class="space-y-4">
                            @foreach($testRuns as $run)
                                <div class="border rounded-lg p-6 hover:shadow-lg transition">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold mb-2">{{ $run->name }}</h3>
                                            @if($run->description)
                                                <p class="text-gray-600 mb-3">{{ $run->description }}</p>
                                            @endif
                                            <div class="flex gap-4 text-sm text-gray-600">
                                                @if($run->environment)
                                                    <span>🌍 {{ $run->environment }}</span>
                                                @endif
                                                @if($run->build_version)
                                                    <span>📦 {{ $run->build_version }}</span>
                                                @endif
                                                <span>👤 {{ $run->creator->name }}</span>
                                                <span>📅 {{ $run->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                        @php
                                            $statusColors = [
                                                'planned' => 'bg-gray-100 text-gray-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'aborted' => 'bg-red-100 text-red-800'
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 text-sm rounded {{ $statusColors[$run->status] }}">
                                            {{ ucfirst(str_replace('_', ' ', $run->status)) }}
                                        </span>
                                    </div>

                                    @php
                                        $counts = $run->statusCounts;
                                        $total = array_sum($counts);
                                        $passRate = $run->passRate;
                                    @endphp

                                    <div class="mb-4">
                                        <div class="flex justify-between text-sm mb-2">
                                            <span class="font-medium">Progress: {{ $total - $counts['pending'] }}/{{ $total }} tests</span>
                                            <span class="font-medium">Pass Rate: {{ $passRate }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                            @if($total > 0)
                                                <div class="h-3 flex">
                                                    @if($counts['passed'] > 0)
                                                        <div class="bg-green-500" style="width: {{ ($counts['passed']/$total)*100 }}%"></div>
                                                    @endif
                                                    @if($counts['failed'] > 0)
                                                        <div class="bg-red-500" style="width: {{ ($counts['failed']/$total)*100 }}%"></div>
                                                    @endif
                                                    @if($counts['blocked'] > 0)
                                                        <div class="bg-yellow-500" style="width: {{ ($counts['blocked']/$total)*100 }}%"></div>
                                                    @endif
                                                    @if($counts['skipped'] > 0)
                                                        <div class="bg-blue-400" style="width: {{ ($counts['skipped']/$total)*100 }}%"></div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <div class="flex gap-4 text-sm">
                                            <span class="text-green-600">✓ {{ $counts['passed'] }} Passed</span>
                                            <span class="text-red-600">✗ {{ $counts['failed'] }} Failed</span>
                                            <span class="text-yellow-600">⊘ {{ $counts['blocked'] }} Blocked</span>
                                            <span class="text-blue-600">→ {{ $counts['skipped'] }} Skipped</span>
                                            <span class="text-gray-600">○ {{ $counts['pending'] }} Pending</span>
                                        </div>
                                        <div class="flex gap-2">
                                            @if($run->status === 'planned' || $run->status === 'in_progress')
                                                <a href="{{ route('projects.test-runs.execute', [$project, $run]) }}" 
                                                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                    Execute
                                                </a>
                                            @endif
                                            <a href="{{ route('projects.test-runs.show', [$project, $run]) }}" 
                                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $testRuns->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <p class="text-gray-500 mt-4 mb-4">No test runs yet. Create your first test run!</p>
                            <a href="{{ route('projects.test-runs.create', $project) }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                + Create Test Run
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
