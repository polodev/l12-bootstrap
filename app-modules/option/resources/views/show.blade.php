<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Option Details</h2>
                    <p class="text-gray-600 dark:text-gray-400">View option information and configuration</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('option::admin.options.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Options
                    </a>
                    <a href="{{ route('option::admin.options.edit', $option) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Option
                    </a>
                    @unless($option->is_system)
                        <button onclick="deleteOption({{ $option->id }}, '{{ addslashes($option->option_name) }}')" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Option
                        </button>
                    @endunless
                </div>
            </div>
        </div>

        <!-- Option Details -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Basic Information -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Basic Information</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Option Name</label>
                                <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md">
                                    <code class="text-sm font-mono text-gray-900 dark:text-gray-100">{{ $option->option_name }}</code>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Batch Name</label>
                                <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md">
                                    @if($option->batch_name)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-800 dark:text-indigo-300">
                                            {{ $option->batch_name }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-500 dark:text-gray-400">No batch assigned</span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data Type</label>
                                <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md">
                                    {!! $option->type_badge !!}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Position</label>
                                <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md">
                                    <span class="inline-flex items-center justify-center w-8 h-8 text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 rounded-full">
                                        {{ $option->position ?? 0 }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md min-h-[2.5rem]">
                                    <span class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $option->description ?: 'No description provided' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Siblings Section -->
                    @if($option->batch_name && $siblings->count() > 0)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                            Batch Siblings
                            <span class="ml-2 text-sm font-normal text-gray-500 dark:text-gray-400">
                                ({{ $siblings->count() }} other options in "{{ $option->batch_name }}" batch)
                            </span>
                        </h3>
                        
                        <div class="space-y-2">
                            @foreach($siblings as $sibling)
                                <a href="{{ route('option::admin.options.show', $sibling->id) }}" 
                                   class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors group">
                                    <div class="flex items-center space-x-3">
                                        <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-medium bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-300 rounded-full">
                                            {{ $sibling->position ?? 0 }}
                                        </span>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                                {{ $sibling->option_name }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                ID: {{ $sibling->id }}
                                            </div>
                                        </div>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Configuration Flags -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Configuration</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Autoload Status</label>
                                <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md">
                                    {!! $option->autoload_badge !!}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">System Status</label>
                                <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md">
                                    {!! $option->system_badge !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Option Value -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Option Value</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Value</label>
                            <div class="relative">
                                @if(in_array($option->option_type, ['json', 'array']))
                                    <pre class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md p-4 text-sm font-mono text-gray-900 dark:text-gray-100 overflow-x-auto max-h-80 overflow-y-auto">{{ $option->formatted_value }}</pre>
                                @else
                                    <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md min-h-[2.5rem] max-h-60 overflow-y-auto">
                                        @if($option->option_type === 'boolean')
                                            <span class="text-sm font-mono text-gray-900 dark:text-gray-100">
                                                {{ $option->formatted_value === 'true' ? '✓ True' : '✗ False' }}
                                            </span>
                                        @else
                                            <span class="text-sm font-mono text-gray-900 dark:text-gray-100 break-words">
                                                {{ $option->formatted_value ?: 'Empty value' }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                                
                                <!-- Copy button -->
                                <button onclick="copyToClipboard('{{ addslashes($option->formatted_value) }}')" 
                                        class="absolute top-2 right-2 p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 bg-white dark:bg-gray-800 rounded border border-gray-200 dark:border-gray-600 shadow-sm hover:shadow"
                                        title="Copy value">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Raw Value (for debugging) -->
                    @if($option->option_type !== 'string')
                        <div>
                            <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Raw Storage Value</h4>
                            <div class="relative">
                                <div class="px-3 py-2 bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-md text-xs font-mono text-gray-600 dark:text-gray-400 max-h-32 overflow-y-auto">
                                    {{ $option->option_value ?: 'NULL' }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Usage Example -->
                    <div>
                        <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Usage Example</h4>
                        <div class="px-3 py-2 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-md">
                            <code class="text-sm font-mono text-blue-800 dark:text-blue-200">
                                Option::get('{{ $option->option_name }}')
                            </code>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Timestamps</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Created At</label>
                        <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md">
                            <span class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $option->created_at->format('M d, Y H:i:s') }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Last Updated</label>
                        <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md">
                            <span class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $option->updated_at->format('M d, Y H:i:s') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show success message
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50';
                toast.textContent = 'Value copied to clipboard!';
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 3000);
            }).catch(function(err) {
                console.error('Could not copy text: ', err);
                alert('Could not copy to clipboard');
            });
        }

        function deleteOption(optionId, optionName) {
            if (confirm(`Are you sure you want to delete the option "${optionName}"?`)) {
                fetch(`{{ url('dashboard/options') }}/${optionId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '{{ route('option::admin.options.index') }}';
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the option.');
                });
            }
        }
    </script>
    @endpush
</x-admin-dashboard-layout::layout>