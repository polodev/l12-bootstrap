<x-admin-dashboard-layout::layout>
    <x-slot name="title">{{ $myFile->title }}</x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('my-file::index') }}" 
                       class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to Files
                    </a>
                    <span class="text-gray-300 dark:text-gray-600">/</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $myFile->title }}</span>
                </div>
                <div class="mt-2 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $myFile->title }}</h1>
                        <div class="mt-1 flex items-center space-x-4">
                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $myFile->is_active ? 'text-green-800 bg-green-100 dark:bg-green-800 dark:text-green-100' : 'text-red-800 bg-red-100 dark:bg-red-800 dark:text-red-100' }}">
                                {{ $myFile->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Created {{ $myFile->created_at->format('M j, Y \a\t g:i A') }}
                            </span>
                            @if($myFile->updated_at != $myFile->created_at)
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    Updated {{ $myFile->updated_at->format('M j, Y \a\t g:i A') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('my-file::edit', $myFile) }}" 
                           class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('my-file::destroy', $myFile) }}" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this file? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                                <i class="fas fa-trash mr-2"></i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- File Information -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">File Information</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Description
                                </label>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    @if($myFile->description)
                                        <p class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $myFile->description }}</p>
                                    @else
                                        <p class="text-gray-500 dark:text-gray-400 italic">No description provided</p>
                                    @endif
                                </div>
                            </div>

                            <!-- File Details -->
                            @if($myFile->hasFile())
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        File Details
                                    </label>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <dl class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">File Name</dt>
                                                <dd class="text-sm text-gray-900 dark:text-gray-100 break-all">{{ $myFile->file_name }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">File Size</dt>
                                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $myFile->file_size }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">File Type</dt>
                                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ strtoupper($myFile->file_extension) }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">MIME Type</dt>
                                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $myFile->getFirstMedia('my_file')->mime_type }}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Actions
                                    </label>
                                    <div class="flex flex-wrap gap-3">
                                        <a href="{{ route('my-file::download', $myFile) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                                            <i class="fas fa-download mr-2"></i>
                                            Download File
                                        </a>
                                        <a href="{{ $myFile->file_url }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                                            <i class="fas fa-external-link-alt mr-2"></i>
                                            View File
                                        </a>
                                        <button onclick="copyToClipboard('{{ $myFile->file_url }}')" 
                                                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                                            <i class="fas fa-copy mr-2"></i>
                                            Copy URL
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-file-slash text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500 dark:text-gray-400">No file attached to this record</p>
                                    <a href="{{ route('my-file::edit', $myFile) }}" 
                                       class="mt-3 inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500">
                                        <i class="fas fa-upload mr-1"></i>
                                        Upload a file
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- File Preview -->
                <div>
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">File Preview</h3>
                        </div>
                        <div class="p-6">
                            @if($myFile->hasFile())
                                @php
                                    $extension = $myFile->file_extension;
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                                    $isPdf = strtolower($extension) === 'pdf';
                                    $isVideo = in_array(strtolower($extension), ['mp4', 'webm', 'ogg']);
                                    $isAudio = in_array(strtolower($extension), ['mp3', 'wav', 'ogg', 'm4a']);
                                @endphp
                                
                                @if($isImage && $myFile->file_url)
                                    <div class="text-center">
                                        <img src="{{ $myFile->file_url }}" 
                                             alt="{{ $myFile->title }}" 
                                             class="max-w-full h-auto rounded-lg shadow-md mx-auto"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                        <div class="bg-gray-200 dark:bg-gray-700 rounded-lg p-8 text-center" style="display: none;">
                                            <span class="text-gray-600 dark:text-gray-300">Image preview not available</span>
                                        </div>
                                    </div>
                                @elseif($isImage)
                                    <div class="text-center">
                                        <div class="bg-gray-200 dark:bg-gray-700 rounded-lg p-8">
                                            <span class="text-gray-600 dark:text-gray-300">Image preview not available</span>
                                        </div>
                                    </div>
                                @elseif($isPdf)
                                    <div class="text-center">
                                        <div class="bg-red-100 dark:bg-red-900 rounded-lg p-8">
                                            <i class="fas fa-file-pdf text-6xl text-red-600 dark:text-red-400 mb-4"></i>
                                            <p class="text-red-800 dark:text-red-300 font-medium">PDF Document</p>
                                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $myFile->file_size }}</p>
                                        </div>
                                    </div>
                                @elseif($isVideo)
                                    <div class="text-center">
                                        <video controls class="max-w-full h-auto rounded-lg shadow-md mx-auto">
                                            <source src="{{ $myFile->file_url }}" type="video/{{ strtolower($extension) }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                @elseif($isAudio)
                                    <div class="text-center">
                                        <div class="bg-purple-100 dark:bg-purple-900 rounded-lg p-8 mb-4">
                                            <i class="fas fa-music text-6xl text-purple-600 dark:text-purple-400 mb-4"></i>
                                            <p class="text-purple-800 dark:text-purple-300 font-medium">Audio File</p>
                                            <p class="text-sm text-purple-600 dark:text-purple-400 mt-1">{{ $myFile->file_size }}</p>
                                        </div>
                                        <audio controls class="w-full">
                                            <source src="{{ $myFile->file_url }}" type="audio/{{ strtolower($extension) }}">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-8">
                                            <i class="fas fa-file text-6xl text-gray-600 dark:text-gray-400 mb-4"></i>
                                            <p class="text-gray-800 dark:text-gray-300 font-medium">{{ strtoupper($extension) }} File</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $myFile->file_size }}</p>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-file-slash text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-500 dark:text-gray-400">No file to preview</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(text) {
            // Modern browsers with clipboard API
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(function() {
                    showCopyNotification('URL copied to clipboard!', 'success');
                }, function(err) {
                    console.error('Could not copy text: ', err);
                    fallbackCopyToClipboard(text);
                });
            } else {
                // Fallback for older browsers or non-secure contexts
                fallbackCopyToClipboard(text);
            }
        }

        function fallbackCopyToClipboard(text) {
            // Create a temporary textarea element
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            
            textArea.focus();
            textArea.select();
            
            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showCopyNotification('URL copied to clipboard!', 'success');
                } else {
                    showCopyNotification('Failed to copy URL. Please copy manually.', 'error');
                }
            } catch (err) {
                console.error('Fallback copy failed: ', err);
                showCopyNotification('Copy not supported. Please copy manually.', 'error');
            }
            
            document.body.removeChild(textArea);
        }

        function showCopyNotification(message, type) {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            notification.className = `fixed top-4 right-4 ${bgColor} text-white px-4 py-2 rounded-md shadow-lg z-50 transition-opacity duration-300`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            // Fade in
            setTimeout(() => {
                notification.style.opacity = '1';
            }, 10);
            
            // Fade out and remove
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
    </script>
    @endpush
</x-admin-dashboard-layout::layout>