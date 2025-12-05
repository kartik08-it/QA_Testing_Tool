<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Test Case #{{ $testCase->id }}: {{ $testCase->title }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $project->name }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('projects.test-cases.edit', [$project, $testCase]) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('projects.test-cases.index', $project) }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-black font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Main Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <div class="text-sm text-gray-500">Priority</div>
                            @php
                                $colors = [
                                    'low' => 'bg-gray-100 text-gray-800',
                                    'medium' => 'bg-yellow-100 text-yellow-800',
                                    'high' => 'bg-orange-100 text-orange-800',
                                    'critical' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-block mt-1 px-3 py-1 text-sm rounded {{ $colors[$testCase->priority] }}">
                                {{ ucfirst($testCase->priority) }}
                            </span>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Type</div>
                            <div class="mt-1 font-medium">{{ ucfirst($testCase->type) }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Status</div>
                            @php
                                $statusColors = [
                                    'draft' => 'bg-gray-100 text-gray-800',
                                    'ready' => 'bg-green-100 text-green-800',
                                    'deprecated' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-block mt-1 px-3 py-1 text-sm rounded {{ $statusColors[$testCase->status] }}">
                                {{ ucfirst($testCase->status) }}
                            </span>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Automated</div>
                            <div class="mt-1 font-medium">{{ ucfirst($testCase->automated) }}</div>
                        </div>
                    </div>

                    @if($testCase->testSuite)
                        <div class="mb-6">
                            <div class="text-sm text-gray-500">Test Suite</div>
                            <div class="mt-1 font-medium">{{ $testCase->testSuite->name }}</div>
                        </div>
                    @endif

                    @if($testCase->description)
                        <div class="mb-6">
                            <h3 class="font-semibold text-lg mb-2">Description</h3>
                            <p class="text-gray-700">{{ $testCase->description }}</p>
                        </div>
                    @endif

                    @if($testCase->preconditions)
                        <div class="mb-6">
                            <h3 class="font-semibold text-lg mb-2">Preconditions</h3>
                            <p class="text-gray-700">{{ $testCase->preconditions }}</p>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-3">Test Steps</h3>
                        <div class="space-y-3">
                            @foreach($testCase->steps as $index => $step)
                                <div class="border-l-4 border-blue-500 pl-4 py-2">
                                    <div class="font-medium text-gray-900">
                                        Step {{ $index + 1 }}: {{ $step['action'] }}
                                    </div>
                                    @if(!empty($step['expected']))
                                        <div class="text-sm text-gray-600 mt-1">
                                            Expected: {{ $step['expected'] }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-2">Expected Result</h3>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="text-gray-700">{{ $testCase->expected_result }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <span class="font-medium">Created by:</span> {{ $testCase->creator->name }}
                        </div>
                        <div>
                            <span class="font-medium">Created at:</span> {{ $testCase->created_at->format('M d, Y H:i') }}
                        </div>
                        @if($testCase->estimated_time)
                            <div>
                                <span class="font-medium">Estimated time:</span> {{ $testCase->estimated_time }} minutes
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Execution History -->
            @if($testCase->executions->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg mb-4">Execution History</h3>
                        <div class="space-y-3">
                            @foreach($testCase->executions as $execution)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="font-medium">{{ $execution->testRun->name }}</div>
                                            <div class="text-sm text-gray-600">
                                                Executed {{ $execution->executed_at?->diffForHumans() ?? 'Not executed yet' }}
                                            </div>
                                        </div>
                                        @php
                                            $statusBadges = [
                                                'pending' => 'bg-gray-100 text-gray-800',
                                                'passed' => 'bg-green-100 text-green-800',
                                                'failed' => 'bg-red-100 text-red-800',
                                                'blocked' => 'bg-yellow-100 text-yellow-800',
                                                'skipped' => 'bg-blue-100 text-blue-800'
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 text-sm rounded {{ $statusBadges[$execution->status] }}">
                                            {{ ucfirst($execution->status) }}
                                        </span>
                                    </div>
                                    @if($execution->comments)
                                        <div class="mt-2 text-sm text-gray-600">
                                            <span class="font-medium">Comments:</span> {{ $execution->comments }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
