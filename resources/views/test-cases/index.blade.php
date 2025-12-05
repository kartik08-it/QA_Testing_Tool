<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Test Cases - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.test-cases.create', $project) }}" 
               class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                + Create Test Case
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search test cases..." 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>
                        
                        <div>
                            <select name="priority" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                <option value="">All Priorities</option>
                                <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                                <option value="critical" {{ request('priority') === 'critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                        </div>
                        
                        <div>
                            <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                <option value="">All Statuses</option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="ready" {{ request('status') === 'ready' ? 'selected' : '' }}>Ready</option>
                                <option value="deprecated" {{ request('status') === 'deprecated' ? 'selected' : '' }}>Deprecated</option>
                            </select>
                        </div>
                        
                        <div class="flex gap-2">
                            <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-black font-bold py-2 px-4 rounded flex-1">
                                Filter
                            </button>
                            <a href="{{ route('projects.test-cases.index', $project) }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Test Cases List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($testCases->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Priority</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Suite</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($testCases as $testCase)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                #{{ $testCase->id }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-900">{{ $testCase->title }}</div>
                                                @if($testCase->description)
                                                    <div class="text-sm text-gray-500">{{ Str::limit($testCase->description, 60) }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $colors = [
                                                        'low' => 'bg-gray-100 text-gray-800',
                                                        'medium' => 'bg-yellow-100 text-yellow-800',
                                                        'high' => 'bg-orange-100 text-orange-800',
                                                        'critical' => 'bg-red-100 text-red-800'
                                                    ];
                                                @endphp
                                                <span class="px-2 py-1 text-xs rounded {{ $colors[$testCase->priority] ?? 'bg-gray-100' }}">
                                                    {{ ucfirst($testCase->priority) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ ucfirst($testCase->type) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'draft' => 'bg-gray-100 text-gray-800',
                                                        'ready' => 'bg-green-100 text-green-800',
                                                        'deprecated' => 'bg-red-100 text-red-800'
                                                    ];
                                                @endphp
                                                <span class="px-2 py-1 text-xs rounded {{ $statusColors[$testCase->status] ?? 'bg-gray-100' }}">
                                                    {{ ucfirst($testCase->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $testCase->testSuite?->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('projects.test-cases.show', [$project, $testCase]) }}" 
                                                   class="text-blue-600 hover:text-blue-900 mr-3">
                                                    View
                                                </a>
                                                <a href="{{ route('projects.test-cases.edit', [$project, $testCase]) }}" 
                                                   class="text-green-600 hover:text-green-900">
                                                    Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $testCases->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500 mt-4 mb-4">No test cases found. Create your first test case!</p>
                            <a href="{{ route('projects.test-cases.create', $project) }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                                + Create Test Case
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>