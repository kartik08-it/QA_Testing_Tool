<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $project->name }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $project->key }}</p>
            </div>
            <div class="flex gap-3">
                @if($project->created_by === auth()->id())
                    <a href="{{ route('projects.edit', $project) }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-black font-bold py-2 px-4 rounded">
                        Edit Project
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm mb-2">Test Cases</div>
                    <div class="flex justify-between items-end">
                        <div class="text-3xl font-bold text-blue-600">{{ $stats['total_cases'] }}</div>
                        <a href="{{ route('projects.test-cases.index', $project) }}" class="text-blue-500 hover:text-blue-700 text-sm">
                            View All →
                        </a>
                    </div>
                    <div class="text-xs text-gray-500 mt-2">{{ $stats['ready_cases'] }} ready for testing</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm mb-2">Test Runs</div>
                    <div class="flex justify-between items-end">
                        <div class="text-3xl font-bold text-green-600">{{ $stats['total_runs'] }}</div>
                        <a href="{{ route('projects.test-runs.index', $project) }}" class="text-blue-500 hover:text-blue-700 text-sm">
                            View All →
                        </a>
                    </div>
                    <div class="text-xs text-gray-500 mt-2">{{ $stats['completed_runs'] }} completed</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm mb-2">Defects</div>
                    <div class="flex justify-between items-end">
                        <div class="text-3xl font-bold text-red-600">{{ $stats['active_defects'] }}</div>
                        <a href="{{ route('projects.defects.index', $project) }}" class="text-blue-500 hover:text-blue-700 text-sm">
                            View All →
                        </a>
                    </div>
                    <div class="text-xs text-gray-500 mt-2">{{ $stats['total_defects'] }} total defects</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('projects.test-cases.create', $project) }}" 
                           class="border-2 border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-black font-bold py-3 px-4 rounded-lg text-center transition">
                            + New Test Case
                        </a>
                        <a href="{{ route('projects.test-runs.create', $project) }}" 
                           class="border-2 border-green-500 text-green-500 hover:bg-green-500 hover:text-black font-bold py-3 px-4 rounded-lg text-center transition">
                            + New Test Run
                        </a>
                        <a href="{{ route('projects.defects.create', $project) }}" 
                           class="border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-black font-bold py-3 px-4 rounded-lg text-center transition">
                            + Report Defect
                        </a>
                        <a href="{{ route('projects.reports.index', $project) }}" 
                           class="border-2 border-purple-500 text-purple-500 hover:bg-purple-500 hover:text-black font-bold py-3 px-4 rounded-lg text-center transition">
                            View Reports
                        </a>
                    </div>
                </div>
            </div>

            <!-- Project Description -->
            @if($project->description)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-3">Description</h3>
                    <p class="text-gray-700">{{ $project->description }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>