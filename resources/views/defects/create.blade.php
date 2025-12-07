<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Report Defect - {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('projects.defects.store', $project) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                   placeholder="Brief description of the defect"
                                   required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" 
                                      rows="4" 
                                      class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                      placeholder="Detailed description of the issue..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">
                                Steps to Reproduce
                            </label>
                            <textarea name="steps_to_reproduce" 
                                      rows="5" 
                                      class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                      placeholder="1. Go to...&#10;2. Click on...&#10;3. Observe...">{{ old('steps_to_reproduce') }}</textarea>
                            @error('steps_to_reproduce')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">
                                    Severity <span class="text-red-500">*</span>
                                </label>
                                <select name="severity" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                                    <option value="low" {{ old('severity') === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('severity') === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('severity') === 'high' ? 'selected' : '' }}>High</option>
                                    <option value="critical" {{ old('severity') === 'critical' ? 'selected' : '' }}>Critical</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Impact on system functionality</p>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-bold mb-2">
                                    Priority <span class="text-red-500">*</span>
                                </label>
                                <select name="priority" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                                    <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                                    <option value="critical" {{ old('priority') === 'critical' ? 'selected' : '' }}>Critical</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Urgency to fix</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-bold mb-2">
                                Environment
                            </label>
                            <input type="text" 
                                   name="environment" 
                                   value="{{ old('environment') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                   placeholder="e.g., Production - Chrome 120, Windows 11">
                            <p class="text-xs text-gray-500 mt-1">Browser, OS, device details</p>
                        </div>

                        <div class="flex justify-end gap-4">
                            <a href="{{ route('projects.defects.index', $project) }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-700 text-black font-bold py-2 px-6 rounded-lg">
                                Report Defect
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>