<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Test Coverage Report - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.reports.index', $project) }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Reports
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Overall Coverage -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Overall Test Coverage</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="text-center p-6 bg-blue-50 rounded-lg">
                            <div class="text-4xl font-bold text-blue-600">{{ $totalCases }}</div>
                            <div class="text-sm text-gray-600 mt-2">Total Test Cases</div>
                        </div>
                        
                        <div class="text-center p-6 bg-green-50 rounded-lg">
                            <div class="text-4xl font-bold text-green-600">{{ $executedCases }}</div>
                            <div class="text-sm text-gray-600 mt-2">Executed Cases</div>
                        </div>
                        
                        <div class="text-center p-6 bg-purple-50 rounded-lg">
                            <div class="text-4xl font-bold text-purple-600">
                                {{ $totalCases > 0 ? round(($executedCases / $totalCases) * 100, 1) : 0 }}%
                            </div>
                            <div class="text-sm text-gray-600 mt-2">Coverage Percentage</div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Test Execution Progress</span>
                            <span class="font-medium">
                                {{ $executedCases }} / {{ $totalCases }} cases
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            @php
                                $percentage = $totalCases > 0 ? ($executedCases / $totalCases) * 100 : 0;
                            @endphp
                            <div class="bg-green-500 h-4 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coverage by Priority -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Coverage by Priority</h3>
                    
                    @if($coverageByPriority->count() > 0)
                        <div class="space-y-6">
                            @foreach(['critical', 'high', 'medium', 'low'] as $priority)
                                @php
                                    $data = $coverageByPriority->firstWhere('priority', $priority);
                                    $total = $data->total ?? 0;
                                    $executed = $data->executed ?? 0;
                                    $percentage = $total > 0 ? ($executed / $total) * 100 : 0;
                                    
                                    $colors = [
                                        'critical' => ['bg' => 'bg-red-500', 'text' => 'text-red-600'],
                                        'high' => ['bg' => 'bg-orange-500', 'text' => 'text-orange-600'],
                                        'medium' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-600'],
                                        'low' => ['bg' => 'bg-gray-500', 'text' => 'text-gray-600']
                                    ];
                                @endphp
                                
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="flex items-center gap-3">
                                            <span class="font-semibold capitalize {{ $colors[$priority]['text'] }}">
                                                {{ $priority }} Priority
                                            </span>
                                            <span class="text-sm text-gray-600">
                                                {{ $executed }} / {{ $total }} cases executed
                                            </span>
                                        </div>
                                        <span class="font-bold {{ $colors[$priority]['text'] }}">
                                            {{ round($percentage, 1) }}%
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <div class="{{ $colors[$priority]['bg'] }} h-3 rounded-full" 
                                             style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8">No test cases available for coverage analysis.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
