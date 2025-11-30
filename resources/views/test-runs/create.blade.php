<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Test Run - {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('projects.test-runs.store', $project) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                Test Run Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                   placeholder="Sprint 1 - Authentication Testing"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Description</label>
                            <textarea name="description" 
                                      rows="3" 
                                      class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                      placeholder="Describe the purpose of this test run...">{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Environment</label>
                                <input type="text" 
                                       name="environment" 
                                       value="{{ old('environment') }}"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                       placeholder="e.g., Staging, Production">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Build Version</label>
                                <input type="text" 
                                       name="build_version" 
                                       value="{{ old('build_version') }}"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                       placeholder="e.g., v1.2.0">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-bold mb-3">
                                Select Test Cases <span class="text-red-500">*</span>
                            </label>
                            
                            @if($testCases->count() > 0)
                                <div class="mb-3 flex gap-2">
                                    <button type="button" onclick="selectAll()" class="text-sm text-blue-600 hover:text-blue-800">
                                        Select All
                                    </button>
                                    <span class="text-gray-400">|</span>
                                    <button type="button" onclick="deselectAll()" class="text-sm text-blue-600 hover:text-blue-800">
                                        Deselect All
                                    </button>
                                    <span class="text-gray-400">|</span>
                                    <button type="button" onclick="selectReady()" class="text-sm text-blue-600 hover:text-blue-800">
                                        Select Ready Only
                                    </button>
                                </div>

                                <div class="border border-gray-300 rounded-lg p-4 max-h-96 overflow-y-auto">
                                    <div class="space-y-2">
                                        @foreach($testCases as $testCase)
                                            <label class="flex items-start p-3 hover:bg-gray-50 rounded cursor-pointer">
                                                <input type="checkbox" 
                                                       name="test_cases[]" 
                                                       value="{{ $testCase->id }}"
                                                       data-status="{{ $testCase->status }}"
                                                       class="mt-1 mr-3 test-case-checkbox"
                                                       {{ in_array($testCase->id, old('test_cases', [])) ? 'checked' : '' }}>
                                                <div class="flex-1">
                                                    <div class="font-medium text-gray-900">
                                                        #{{ $testCase->id }} - {{ $testCase->title }}
                                                    </div>
                                                    <div class="flex gap-2 mt-1">
                                                        @php
                                                            $priorityColors = [
                                                                'low' => 'bg-gray-100 text-gray-800',
                                                                'medium' => 'bg-yellow-100 text-yellow-800',
                                                                'high' => 'bg-orange-100 text-orange-800',
                                                                'critical' => 'bg-red-100 text-red-800'
                                                            ];
                                                            $statusColors = [
                                                                'draft' => 'bg-gray-100 text-gray-800',
                                                                'ready' => 'bg-green-100 text-green-800',
                                                                'deprecated' => 'bg-red-100 text-red-800'
                                                            ];
                                                        @endphp
                                                        <span class="text-xs px-2 py-1 rounded {{ $priorityColors[$testCase->priority] }}">
                                                            {{ ucfirst($testCase->priority) }}
                                                        </span>
                                                        <span class="text-xs px-2 py-1 rounded {{ $statusColors[$testCase->status] }}">
                                                            {{ ucfirst($testCase->status) }}
                                                        </span>
                                                        <span class="text-xs text-gray-500">
                                                            {{ ucfirst($testCase->type) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                @error('test_cases')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            @else
                                <div class="border border-gray-300 rounded-lg p-6 text-center">
                                    <p class="text-gray-500 mb-3">No test cases available yet.</p>
                                    <a href="{{ route('projects.test-cases.create', $project) }}" 
                                       class="text-blue-500 hover:text-blue-700">
                                        Create test cases first →
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('projects.test-runs.index', $project) }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg"
                                    @if($testCases->count() === 0) disabled @endif>
                                Create Test Run
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectAll() {
            document.querySelectorAll('.test-case-checkbox').forEach(cb => cb.checked = true);
        }

        function deselectAll() {
            document.querySelectorAll('.test-case-checkbox').forEach(cb => cb.checked = false);
        }

        function selectReady() {
            document.querySelectorAll('.test-case-checkbox').forEach(cb => {
                cb.checked = cb.dataset.status === 'ready';
            });
        }
    </script>
</x-app-layout>