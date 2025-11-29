<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Test Case - {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('projects.test-cases.store', $project) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Title *</label>
                            <input type="text" name="title" value="{{ old('title') }}" 
                                   class="w-full border rounded px-3 py-2" required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Test Suite</label>
                            <select name="test_suite_id" class="w-full border rounded px-3 py-2">
                                <option value="">-- No Suite --</option>
                                @foreach($testSuites as $suite)
                                    <option value="{{ $suite->id }}">{{ $suite->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Preconditions</label>
                            <textarea name="preconditions" rows="2" class="w-full border rounded px-3 py-2">{{ old('preconditions') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Test Steps *</label>
                            <div id="steps-container">
                                <div class="step-item mb-2 border p-3 rounded">
                                    <input type="text" name="steps[0][action]" placeholder="Step action" 
                                           class="w-full border rounded px-3 py-2 mb-2" required>
                                    <input type="text" name="steps[0][expected]" placeholder="Expected result (optional)" 
                                           class="w-full border rounded px-3 py-2">
                                </div>
                            </div>
                            <button type="button" onclick="addStep()" class="text-blue-500 hover:text-blue-700 mt-2">
                                + Add Step
                            </button>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Expected Result *</label>
                            <textarea name="expected_result" rows="3" class="w-full border rounded px-3 py-2" required>{{ old('expected_result') }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Priority *</label>
                                <select name="priority" class="w-full border rounded px-3 py-2" required>
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Type *</label>
                                <select name="type" class="w-full border rounded px-3 py-2" required>
                                    <option value="functional" selected>Functional</option>
                                    <option value="integration">Integration</option>
                                    <option value="regression">Regression</option>
                                    <option value="smoke">Smoke</option>
                                    <option value="sanity">Sanity</option>
                                    <option value="ui">UI</option>
                                    <option value="api">API</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Automated</label>
                                <select name="automated" class="w-full border rounded px-3 py-2">
                                    <option value="no" selected>No</option>
                                    <option value="yes">Yes</option>
                                    <option value="partial">Partial</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Estimated Time (minutes)</label>
                                <input type="number" name="estimated_time" class="w-full border rounded px-3 py-2" min="1">
                            </div>
                        </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('projects.test-cases.index', $project) }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Test Case
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let stepCount = 1;
        function addStep() {
            const container = document.getElementById('steps-container');
            const stepHtml = `
                <div class="step-item mb-2 border p-3 rounded">
                    <input type="text" name="steps[${stepCount}][action]" placeholder="Step action" 
                           class="w-full border rounded px-3 py-2 mb-2" required>
                    <input type="text" name="steps[${stepCount}][expected]" placeholder="Expected result (optional)" 
                           class="w-full border rounded px-3 py-2">
                </div>
            `;
            container.insertAdjacentHTML('beforeend', stepHtml);
            stepCount++;
        }
    </script>
</x-app-layout>