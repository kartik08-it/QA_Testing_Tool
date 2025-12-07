<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $testRun->name }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $project->name }}</p>
            </div>
            <div class="flex gap-3">
                @if($testRun->status !== 'completed')
                    <a href="{{ route('projects.test-runs.execute', [$project, $testRun]) }}" 
                       class="bg-green-500 hover:bg-green-700 text-black font-bold py-2 px-4 rounded">
                        Execute Tests
                    </a>
                @endif
                <a href="{{ route('projects.test-runs.index', $project) }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-black font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Overview Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                        <div>
                            <div class="text-sm text-gray-500">Status</div>
                            @php
                                $statusColors = [
                                    'planned' => 'bg-gray-100 text-gray-800',
                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'aborted' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-block mt-1 px-3 py-1 text-sm rounded {{ $statusColors[$testRun->status] }}">
                                {{ ucfirst(str_replace('_', ' ', $testRun->status)) }}
                            </span>
                        </div>

                        @if($testRun->environment)
                            <div>
                                <div class="text-sm text-gray-500">Environment</div>
                                <div class="mt-1 font-medium">{{ $testRun->environment }}</div>
                            </div>
                        @endif

                        @if($testRun->build_version)
                            <div>
                                <div class="text-sm text-gray-500">Build Version</div>
                                <div class="mt-1 font-medium">{{ $testRun->build_version }}</div>
                            </div>
                        @endif

                        <div>
                            <div class="text-sm text-gray-500">Created By</div>
                            <div class="mt-1 font-medium">{{ $testRun->creator->name }}</div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-500">Created At</div>
                            <div class="mt-1 font-medium">{{ $testRun->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>

                    @if($testRun->description)
                        <div class="mb-6">
                            <h3 class="font-semibold mb-2">Description</h3>
                            <p class="text-gray-700">{{ $testRun->description }}</p>
                        </div>
                    @endif

                    @php
                        $counts = $testRun->statusCounts;
                        $total = array_sum($counts);
                        $passRate = $testRun->passRate;
                    @endphp

                    <!-- Statistics -->
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-4">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-3xl font-bold text-gray-900">{{ $total }}</div>
                            <div class="text-sm text-gray-600">Total</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-3xl font-bold text-green-600">{{ $counts['passed'] }}</div>
                            <div class="text-sm text-gray-600">Passed</div>
                        </div>
                        <div class="text-center p-4 bg-red-50 rounded-lg">
                            <div class="text-3xl font-bold text-red-600">{{ $counts['failed'] }}</div>
                            <div class="text-sm text-gray-600">Failed</div>
                        </div>
                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                            <div class="text-3xl font-bold text-yellow-600">{{ $counts['blocked'] }}</div>
                            <div class="text-sm text-gray-600">Blocked</div>
                        </div>
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-3xl font-bold text-blue-600">{{ $counts['pending'] }}</div>
                            <div class="text-sm text-gray-600">Pending</div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Progress</span>
                            <span class="font-medium">{{ $passRate }}% Pass Rate</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            @if($total > 0)
                                <div class="h-4 rounded-full flex">
                                    @if($counts['passed'] > 0)
                                        <div class="bg-green-500 h-4 first:rounded-l-full" 
                                             style="width: {{ ($counts['passed'] / $total) * 100 }}%"></div>
                                    @endif
                                    @if($counts['failed'] > 0)
                                        <div class="bg-red-500 h-4" 
                                             style="width: {{ ($counts['failed'] / $total) * 100 }}%"></div>
                                    @endif
                                    @if($counts['blocked'] > 0)
                                        <div class="bg-yellow-500 h-4" 
                                             style="width: {{ ($counts['blocked'] / $total) * 100 }}%"></div>
                                    @endif
                                    @if($counts['skipped'] > 0)
                                        <div class="bg-blue-400 h-4" 
                                             style="width: {{ ($counts['skipped'] / $total) * 100 }}%"></div>
                                    @endif
                                    @if($counts['pending'] > 0)
                                        <div class="bg-gray-300 h-4 last:rounded-r-full" 
                                             style="width: {{ ($counts['pending'] / $total) * 100 }}%"></div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test Executions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Test Cases</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Test Case</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Executed By</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Executed At</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Comments</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($testRun->executions as $execution)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <a href="{{ route('projects.test-cases.show', [$project, $execution->testCase]) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                #{{ $execution->testCase->id }} - {{ $execution->testCase->title }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusBadges = [
                                                    'pending' => 'bg-gray-100 text-gray-800',
                                                    'passed' => 'bg-green-100 text-green-800',
                                                    'failed' => 'bg-red-100 text-red-800',
                                                    'blocked' => 'bg-yellow-100 text-yellow-800',
                                                    'skipped' => 'bg-blue-100 text-blue-800'
                                                ];
                                            @endphp
                                            <span class="px-2 py-1 text-xs rounded {{ $statusBadges[$execution->status] }}">
                                                {{ ucfirst($execution->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $execution->executor?->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $execution->executed_at?->format('M d, Y H:i') ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ Str::limit($execution->comments, 50) ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
