<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Create Documentation</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Add new documentation to help users</p>
                </div>
                <a href="{{ route('documentation::admin.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('documentation::admin.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Title *
                        </label>
                        <input type="text" 
                               id="title"
                               name="title"
                               value="{{ old('title') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter documentation title"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Section -->
                    <div>
                        <label for="section" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Section *
                        </label>
                        <select id="section"
                                name="section"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Select Section</option>
                            @foreach ($sections as $key => $value)
                                <option value="{{ $key }}" {{ old('section') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('section')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Difficulty -->
                    <div>
                        <label for="difficulty" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Difficulty Level
                        </label>
                        <select id="difficulty"
                                name="difficulty"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Not Specified</option>
                            @foreach ($difficulties as $key => $value)
                                <option value="{{ $key }}" {{ old('difficulty') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('difficulty')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Position -->
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Position
                        </label>
                        <input type="number" 
                               id="position"
                               name="position"
                               value="{{ old('position', 0) }}"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Order position (0 = first)">
                        @error('position')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Content *
                    </label>
                    <textarea id="content"
                              name="content"
                              rows="20"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Write your documentation content here... (Markdown supported)"
                              required>{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Use Markdown syntax for formatting. The editor supports live preview, toolbar actions, and more.
                    </p>
                </div>

                <!-- Published Status -->
                <div class="flex items-center">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" 
                           id="is_published"
                           name="is_published"
                           value="1"
                           {{ old('is_published', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                    <label for="is_published" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                        Publish immediately (uncheck to save as draft)
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('documentation::admin.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Documentation
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde@2.18.0/dist/easymde.min.css">
    <style>
        .EasyMDEContainer .editor-toolbar {
            border-color: #d1d5db;
        }
        .dark .EasyMDEContainer .editor-toolbar {
            border-color: #4b5563;
            background-color: #374151;
        }
        .dark .EasyMDEContainer .editor-toolbar button {
            color: #d1d5db;
        }
        .dark .EasyMDEContainer .editor-toolbar button:hover {
            background-color: #4b5563;
        }
        .dark .EasyMDEContainer .CodeMirror {
            background-color: #1f2937;
            color: #f9fafb;
            border-color: #4b5563;
        }
        .dark .EasyMDEContainer .CodeMirror-cursor {
            border-left-color: #f9fafb;
        }
        .dark .EasyMDEContainer .editor-preview {
            background-color: #1f2937;
            color: #f9fafb;
        }
        .dark .EasyMDEContainer .editor-preview-side {
            border-color: #4b5563;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/easymde@2.18.0/dist/easymde.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const easyMDE = new EasyMDE({
                element: document.getElementById('content'),
                spellChecker: false,
                autosave: {
                    enabled: true,
                    uniqueId: "documentation_create",
                    delay: 1000,
                },
                placeholder: "Write your documentation content here...",
                status: ['autosave', 'lines', 'words', 'cursor'],
                toolbar: [
                    "bold", "italic", "heading", "|",
                    "quote", "unordered-list", "ordered-list", "|",
                    "link", "image", "table", "|",
                    "code", "horizontal-rule", "|",
                    "preview", "side-by-side", "fullscreen", "|",
                    "guide"
                ],
                shortcuts: {
                    drawTable: "Cmd-Alt-T",
                    togglePreview: "Cmd-P",
                    toggleSideBySide: "F9",
                    toggleFullScreen: "F11"
                },
                previewClass: ["editor-preview", "prose", "prose-sm", "max-w-none"],
                renderingConfig: {
                    singleLineBreaks: false,
                    codeSyntaxHighlighting: true,
                },
            });

            // Handle form submission
            document.querySelector('form').addEventListener('submit', function() {
                // EasyMDE automatically syncs with the textarea, but let's be explicit
                easyMDE.codemirror.save();
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>