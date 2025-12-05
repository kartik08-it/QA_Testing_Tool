<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projects
            </h2>
            <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                Create Project
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($projects->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($projects as $project)
                                <div class="border rounded-lg p-6 hover:shadow-lg transition">
                                    <div class="flex justify-between items-start mb-4">
                                        <h3 class="text-xl font-bold">{{ $project->name }}</h3>
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                            {{ $project->key }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-600 mb-4">{{ Str::limit($project->description, 100) }}</p>
                                    
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-500">
                                            <div>{{ $project->testCases->count() }} Test Cases</div>
                                            <div>{{ $project->testRuns->count() }} Test Runs</div>
                                        </div>
                                        <a href="{{ route('projects.show', $project) }}" class="text-blue-500 hover:text-blue-700">
                                            View →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $projects->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">No projects yet. Create your first project!</p>
                            <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                                Create Project
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>