<x-admin-dashboard-layout::layout>
    <x-slot name="title">Edit File - {{ $myFile->title }}</x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('my-file::index') }}" 
                       class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to Files
                    </a>
                    <span class="text-gray-300 dark:text-gray-600">/</span>
                    <a href="{{ route('my-file::show', $myFile) }}" 
                       class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                        {{ $myFile->title }}
                    </a>
                    <span class="text-gray-300 dark:text-gray-600">/</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Edit</span>
                </div>
                <h1 class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-100">Edit File</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Update file information and optionally replace the file</p>
            </div>

            <!-- Current File Preview -->
            @if($myFile->hasFile())
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Current File</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-4">
                        @php
                            $extension = $myFile->file_extension;
                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                        @endphp
                        
                        @if($isImage && $myFile->file_url)
                            <img src="{{ $myFile->file_url }}" 
                                 alt="{{ $myFile->title }}" 
                                 class="w-20 h-20 object-cover rounded-lg"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center" style="display: none;">
                                <span class="text-xs font-medium text-gray-600 dark:text-gray-300">IMG</span>
                            </div>
                        @elseif($isImage)
                            <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                <span class="text-xs font-medium text-gray-600 dark:text-gray-300">IMG</span>
                            </div>
                        @else
                            <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">{{ strtoupper($extension) }}</span>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $myFile->file_name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $myFile->file_size }}</p>
                            <div class="mt-2">
                                <a href="{{ route('my-file::download', $myFile) }}" 
                                   class="inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500">
                                    <i class="fas fa-download mr-1"></i>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Form -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <form action="{{ route('my-file::update', $myFile) }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $myFile->title) }}"
                               required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  placeholder="Enter file description (optional)"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $myFile->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Upload (Optional) -->
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Replace File (Optional)
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:border-gray-400 dark:hover:border-gray-500 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <div id="file-upload-icon" class="mx-auto">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                                </div>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label for="file" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload a new file</span>
                                        <input id="file" 
                                               name="file" 
                                               type="file" 
                                               class="sr-only"
                                               accept="*/*">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Any file type up to 10MB (leave empty to keep current file)
                                </p>
                                <div id="file-preview" class="hidden mt-4">
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas fa-file text-gray-500"></i>
                                            <div class="flex-1 min-w-0">
                                                <p id="file-name" class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate"></p>
                                                <p id="file-size" class="text-xs text-gray-500 dark:text-gray-400"></p>
                                            </div>
                                            <button type="button" id="remove-file" class="text-red-500 hover:text-red-700">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('file')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $myFile->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            Active (file will be visible)
                        </label>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('my-file::show', $myFile) }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-save mr-2"></i>
                            Update File
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file');
            const filePreview = document.getElementById('file-preview');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            const removeFileButton = document.getElementById('remove-file');
            const uploadIcon = document.getElementById('file-upload-icon');

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            function showFilePreview(file) {
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                filePreview.classList.remove('hidden');
                uploadIcon.classList.add('hidden');
            }

            function hideFilePreview() {
                filePreview.classList.add('hidden');
                uploadIcon.classList.remove('hidden');
                fileInput.value = '';
            }

            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    showFilePreview(file);
                }
            });

            removeFileButton.addEventListener('click', function() {
                hideFilePreview();
            });

            // Drag and drop functionality
            const dropZone = fileInput.closest('.border-dashed');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropZone.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900');
            }

            function unhighlight(e) {
                dropZone.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900');
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length > 0) {
                    fileInput.files = files;
                    showFilePreview(files[0]);
                }
            }
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>