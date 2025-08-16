<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Option</h2>
                    <p class="text-gray-600 dark:text-gray-400">Update option configuration and value</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('option::admin.options.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Options
                    </a>
                    <a href="{{ route('option::admin.options.show', $option) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Option
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="p-6">
            <form action="{{ route('option::admin.options.update', $option) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column - Basic Information -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Basic Information</h3>
                            
                            <!-- Option Name -->
                            <div class="mb-6">
                                <label for="option_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Option Name *
                                </label>
                                <input type="text" 
                                       id="option_name"
                                       name="option_name"
                                       value="{{ old('option_name', $option->option_name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('option_name') border-red-500 @enderror"
                                       placeholder="Enter unique option name"
                                       required>
                                @error('option_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Batch Name -->
                            <div class="mb-6">
                                <label for="batch_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Batch Name
                                </label>
                                <input type="text" 
                                       id="batch_name"
                                       name="batch_name"
                                       value="{{ old('batch_name', $option->batch_name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('batch_name') border-red-500 @enderror"
                                       placeholder="Optional batch name to group related options">
                                @error('batch_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Option Type -->
                            <div class="mb-6">
                                <label for="option_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Data Type *
                                </label>
                                <select id="option_type"
                                        name="option_type"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('option_type') border-red-500 @enderror"
                                        required
                                        onchange="handleTypeChange()">
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" {{ old('option_type', $option->option_type) === $type ? 'selected' : '' }}>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('option_type')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Description
                                </label>
                                <textarea id="description"
                                          name="description"
                                          rows="4"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                          placeholder="Optional description of what this option is used for">{{ old('description', $option->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Configuration Flags -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Configuration</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="is_autoload"
                                           name="is_autoload"
                                           value="1"
                                           {{ old('is_autoload', $option->is_autoload) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                                    <label for="is_autoload" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Autoload (load automatically on app start)
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="is_system"
                                           name="is_system"
                                           value="1"
                                           {{ old('is_system', $option->is_system) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                                    <label for="is_system" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        System option (protected from deletion)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Option Value -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Option Value</h3>
                            
                            <!-- Dynamic Value Input -->
                            <div id="value-input-container">
                                <label for="option_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Option Value
                                    <span id="value-format-hint" class="text-xs text-gray-500 dark:text-gray-400"></span>
                                </label>
                                
                                <!-- String/Integer/Float Input -->
                                <input type="text" 
                                       id="option_value_text"
                                       name="option_value"
                                       value="{{ old('option_value', $option->option_value) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('option_value') border-red-500 @enderror"
                                       placeholder="Enter option value">

                                <!-- Boolean Select -->
                                <select id="option_value_boolean"
                                        name="option_value_boolean"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('option_value') border-red-500 @enderror hidden">
                                    <option value="">Select value</option>
                                    <option value="1" {{ old('option_value', $option->option_value) === '1' ? 'selected' : '' }}>True</option>
                                    <option value="0" {{ old('option_value', $option->option_value) === '0' ? 'selected' : '' }}>False</option>
                                </select>

                                <!-- JSON/Array Textarea -->
                                <textarea id="option_value_json"
                                          name="option_value_json"
                                          rows="8"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm @error('option_value') border-red-500 @enderror hidden"
                                          placeholder='{"key": "value"} or ["item1", "item2"]'>{{ old('option_value', $option->option_value) }}</textarea>

                                @error('option_value')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Current Value Display -->
                        <div>
                            <h4 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-2">Current Formatted Value</h4>
                            <div class="px-3 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-md max-h-40 overflow-y-auto">
                                @if(in_array($option->option_type, ['json', 'array']))
                                    <pre class="text-sm font-mono text-gray-900 dark:text-gray-100">{{ $option->formatted_value }}</pre>
                                @else
                                    <span class="text-sm font-mono text-gray-900 dark:text-gray-100">{{ $option->formatted_value ?: 'Empty value' }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Data Type Guide -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data Type Guide:</h4>
                            <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                                <li><strong>String:</strong> Text values (e.g., "Hello World")</li>
                                <li><strong>JSON:</strong> Complex objects (e.g., {"key": "value"})</li>
                                <li><strong>Array:</strong> Lists of items (e.g., ["item1", "item2"])</li>
                                <li><strong>Boolean:</strong> True/false values</li>
                                <li><strong>Integer:</strong> Whole numbers (e.g., 42)</li>
                                <li><strong>Float:</strong> Decimal numbers (e.g., 3.14)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('option::admin.options.show', $option) }}" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Option
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function handleTypeChange() {
            const typeSelect = document.getElementById('option_type');
            const textInput = document.getElementById('option_value_text');
            const booleanSelect = document.getElementById('option_value_boolean');
            const jsonTextarea = document.getElementById('option_value_json');
            const formatHint = document.getElementById('value-format-hint');

            // Hide all inputs first
            textInput.classList.add('hidden');
            booleanSelect.classList.add('hidden');
            jsonTextarea.classList.add('hidden');

            // Clear name attributes
            textInput.removeAttribute('name');
            booleanSelect.removeAttribute('name');
            jsonTextarea.removeAttribute('name');

            const selectedType = typeSelect.value;

            switch(selectedType) {
                case 'boolean':
                    booleanSelect.classList.remove('hidden');
                    booleanSelect.setAttribute('name', 'option_value');
                    formatHint.textContent = '(Select true or false)';
                    break;
                case 'json':
                case 'array':
                    jsonTextarea.classList.remove('hidden');
                    jsonTextarea.setAttribute('name', 'option_value');
                    formatHint.textContent = '(JSON format required)';
                    break;
                case 'integer':
                    textInput.classList.remove('hidden');
                    textInput.setAttribute('name', 'option_value');
                    textInput.setAttribute('type', 'number');
                    textInput.removeAttribute('step');
                    formatHint.textContent = '(Whole numbers only)';
                    break;
                case 'float':
                    textInput.classList.remove('hidden');
                    textInput.setAttribute('name', 'option_value');
                    textInput.setAttribute('type', 'number');
                    textInput.setAttribute('step', 'any');
                    formatHint.textContent = '(Decimal numbers allowed)';
                    break;
                default: // string
                    textInput.classList.remove('hidden');
                    textInput.setAttribute('name', 'option_value');
                    textInput.setAttribute('type', 'text');
                    textInput.removeAttribute('step');
                    formatHint.textContent = '';
                    break;
            }
        }

        // Initialize the form on page load
        document.addEventListener('DOMContentLoaded', function() {
            handleTypeChange();
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>