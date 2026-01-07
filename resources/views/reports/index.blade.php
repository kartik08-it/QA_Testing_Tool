<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reports - {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Test Coverage Report -->
                <a href="{{ route('projects.reports.coverage', $project) }}" 
                   class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 rounded-full p-3 mr-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Test Coverage</h3>
                            <p class="text-sm text-gray-600">View test coverage metrics</p>
                        </div>
                    </div>
                    <div class="text-blue-600 font-medium">
                        View Report →
                    </div>
                </a>

                <!-- Test Execution Report -->
                <a href="{{ route('projects.reports.execution', $project) }}" 
                   class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 rounded-full p-3 mr-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Test Execution</h3>
                            <p class="text-sm text-gray-600">View execution trends</p>
                        </div>
                    </div>
                    <div class="text-green-600 font-medium">
                        View Report →
                    </div>
                </a>

                <!-- Defects Report -->
                <a href="{{ route('projects.reports.defects', $project) }}" 
                   class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-100 rounded-full p-3 mr-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Defects</h3>
                            <p class="text-sm text-gray-600">View defect analytics</p>
                        </div>
                    </div>
                    <div class="text-red-600 font-medium">
                        View Report →
                    </div>
                </a>

            </div>

            <!-- Quick Stats -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Project Overview</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $project->testCases()->count() }}</div>
                            <div class="text-sm text-gray-600">Total Test Cases</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">{{ $project->testRuns()->count() }}</div>
                            <div class="text-sm text-gray-600">Test Runs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">
                                {{ $project->testRuns()->where('status', 'completed')->count() }}
                            </div>
                            <div class="text-sm text-gray-600">Completed Runs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-red-600">
                                {{ $project->defects()->whereIn('status', ['open', 'in_progress'])->count() }}
                            </div>
                            <div class="text-sm text-gray-600">Active Defects</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>