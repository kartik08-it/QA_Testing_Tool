<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Test Case - {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('projects.test-cases.update', [$project, $testCase]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Title *</label>
                            <input type="text" name="title" value="{{ old('title', $testCase->title) }}" 
                                   class="w-full border rounded-lg px-3 py-2" required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Test Suite</label>
                            <select name="test_suite_id" class="w-full border rounded-lg px-3 py-2">
                                <option value="">-- No Suite --</option>
                                @foreach($testSuites as $suite)
                                    <option value="{{ $suite->id }}" {{ old('test_suite_id', $testCase->test_suite_id) == $suite->id ? 'selected' : '' }}>
                                        {{ $suite->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('description', $testCase->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Preconditions</label>
                            <textarea name="preconditions" rows="2" class="w-full border rounded-lg px-3 py-2">{{ old('preconditions', $testCase->preconditions) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Test Steps *</label>
                            <div id="steps-container">
                                @foreach(old('steps', $testCase->steps) as $index => $step)
                                    <div class="step-item mb-2 border p-3 rounded">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="font-medium">Step {{ $index + 1 }}</span>
                                            @if($index > 0)
                                                <button type="button" onclick="this.parentElement.parentElement.remove()" 
                                                        class="text-red-500 hover:text-red-700 text-sm">
                                                    Remove
                                                </button>
                                            @endif
                                        </div>
                                        <input type="text" name="steps[{{ $index }}][action]" 
                                               value="{{ $step['action'] ?? '' }}"
                                               placeholder="Step action" 
                                               class="w-full border rounded-lg px-3 py-2 mb-2" required>
                                        <input type="text" name="steps[{{ $index }}][expected]" 
                                               value="{{ $step['expected'] ?? '' }}"
                                               placeholder="Expected result (optional)" 
                                               class="w-full border rounded-lg px-3 py-2">
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addStep()" class="text-blue-500 hover:text-blue-700 mt-2">
                                + Add Step
                            </button>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Expected Result *</label>
                            <textarea name="expected_result" rows="3" class="w-full border rounded-lg px-3 py-2" required>{{ old('expected_result', $testCase->expected_result) }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Priority *</label>
                                <select name="priority" class="w-full border rounded-lg px-3 py-2" required>
                                    <option value="low" {{ old('priority', $testCase->priority) === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority', $testCase->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority', $testCase->priority) === 'high' ? 'selected' : '' }}>High</option>
                                    <option value="critical" {{ old('priority', $testCase->priority) === 'critical' ? 'selected' : '' }}>Critical</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Type *</label>
                                <select name="type" class="w-full border rounded-lg px-3 py-2" required>
                                    <option value="functional" {{ old('type', $testCase->type) === 'functional' ? 'selected' : '' }}>Functional</option>
                                    <option value="integration" {{ old('type', $testCase->type) === 'integration' ? 'selected' : '' }}>Integration</option>
                                    <option value="regression" {{ old('type', $testCase->type) === 'regression' ? 'selected' : '' }}>Regression</option>
                                    <option value="smoke" {{ old('type', $testCase->type) === 'smoke' ? 'selected' : '' }}>Smoke</option>
                                    <option value="sanity" {{ old('type', $testCase->type) === 'sanity' ? 'selected' : '' }}>Sanity</option>
                                    <option value="ui" {{ old('type', $testCase->type) === 'ui' ? 'selected' : '' }}>UI</option>
                                    <option value="api" {{ old('type', $testCase->type) === 'api' ? 'selected' : '' }}>API</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Status *</label>
                                <select name="status" class="w-full border rounded-lg px-3 py-2" required>
                                    <option value="draft" {{ old('status', $testCase->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="ready" {{ old('status', $testCase->status) === 'ready' ? 'selected' : '' }}>Ready</option>
                                    <option value="deprecated" {{ old('status', $testCase->status) === 'deprecated' ? 'selected' : '' }}>Deprecated</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Automated</label>
                                <select name="automated" class="w-full border rounded-lg px-3 py-2">
                                    <option value="no" {{ old('automated', $testCase->automated) === 'no' ? 'selected' : '' }}>No</option>
                                    <option value="yes" {{ old('automated', $testCase->automated) === 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="partial" {{ old('automated', $testCase->automated) === 'partial' ? 'selected' : '' }}>Partial</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Estimated Time (min)</label>
                                <input type="number" name="estimated_time" value="{{ old('estimated_time', $testCase->estimated_time) }}"
                                       class="w-full border rounded-lg px-3 py-2" min="1">
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <button type="button" 
                                    onclick="if(confirm('Are you sure you want to delete this test case?')) document.getElementById('delete-form').submit();"
                                    class="bg-red-500 hover:bg-red-700 text-black font-bold py-2 px-4 rounded">
                                Delete
                            </button>

                            <div class="flex gap-4">
                                <a href="{{ route('projects.test-cases.show', [$project, $testCase]) }}" 
                                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    Cancel
                                </a>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                                    Update Test Case
                                </button>
                            </div>
                        </div>
                    </form>

                    <form id="delete-form" action="{{ route('projects.test-cases.destroy', [$project, $testCase]) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let stepCount = {{ count(old('steps', $testCase->steps)) }};
        
        function addStep() {
            const container = document.getElementById('steps-container');
            const stepHtml = `
                <div class="step-item mb-2 border p-3 rounded">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-medium">Step ${stepCount + 1}</span>
                        <button type="button" onclick="this.parentElement.parentElement.remove()" 
                                class="text-red-500 hover:text-red-700 text-sm">
                            Remove
                        </button>
                    </div>
                    <input type="text" name="steps[${stepCount}][action]" placeholder="Step action" 
                           class="w-full border rounded-lg px-3 py-2 mb-2" required>
                    <input type="text" name="steps[${stepCount}][expected]" placeholder="Expected result (optional)" 
                           class="w-full border rounded-lg px-3 py-2">
                </div>
            `;
            container.insertAdjacentHTML('beforeend', stepHtml);
            stepCount++;
        }
    </script>
</x-app-layout>