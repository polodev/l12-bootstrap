<?php

use Livewire\Volt\Component;
use Modules\Option\Models\Option;

new class extends Component {
    public $showModal = false;
    public $option_name = '';
    public $batch_name = '';
    public $option_value = '';
    public $option_type = 'string';
    public $description = '';
    public $position = 0;
    public $is_autoload = false;
    public $is_system = false;

    protected $listeners = ['open-create-modal' => 'openModal'];

    public function rules()
    {
        return [
            'option_name' => 'required|string|max:255|unique:options,option_name',
            'batch_name' => 'nullable|string|max:255',
            'option_value' => 'nullable',
            'option_type' => 'required|in:string,json,array,boolean,integer,float',
            'description' => 'nullable|string',
            'position' => 'integer|min:0',
            'is_autoload' => 'boolean',
            'is_system' => 'boolean'
        ];
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->resetForm();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetValidation();
    }

    public function resetForm()
    {
        $this->option_name = '';
        $this->batch_name = '';
        $this->option_value = '';
        $this->option_type = 'string';
        $this->description = '';
        $this->position = 0;
        $this->is_autoload = false;
        $this->is_system = false;
    }

    public function save()
    {
        $this->validate();

        // Handle JSON validation for json and array types
        if (in_array($this->option_type, ['json', 'array'])) {
            if ($this->option_value && !json_decode($this->option_value)) {
                $this->addError('option_value', 'Invalid JSON format for ' . $this->option_type . ' type.');
                return;
            }
        }

        try {
            $success = Option::set(
                $this->option_name,
                $this->option_value,
                $this->option_type,
                $this->description,
                $this->is_autoload,
                $this->batch_name,
                $this->position
            );

            if ($success) {
                // Set is_system flag if provided
                if ($this->is_system) {
                    Option::where('option_name', $this->option_name)
                          ->update(['is_system' => true]);
                }

                $this->closeModal();
                
                // Dispatch browser event to refresh DataTable
                $this->dispatch('optionCreated');
                
                session()->flash('success', 'Option created successfully!');
            } else {
                $this->addError('option_name', 'Failed to create option.');
            }
        } catch (\Exception $e) {
            $this->addError('option_name', 'Error: ' . $e->getMessage());
        }
    }

    public function updatedOptionType()
    {
        // Clear option_value when type changes to avoid validation issues
        if (in_array($this->option_type, ['json', 'array']) && $this->option_value) {
            // Try to format existing value as JSON if it's not already
            if (!json_decode($this->option_value)) {
                $this->option_value = '';
            }
        }
    }
}; ?>

<div>
    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
             wire:click="closeModal"></div>

        <!-- Modal dialog -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
                 wire:click.stop>
                
                <!-- Modal header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Create New Option
                    </h3>
                    <button type="button" 
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                            wire:click="closeModal">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <form wire:submit="save" class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Option Name -->
                        <div>
                            <label for="option_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Option Name *
                            </label>
                            <input type="text" 
                                   id="option_name"
                                   wire:model="option_name"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter unique option name (e.g., site_title, api_key)"
                                   required>
                            @error('option_name') 
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                        </div>

                        <!-- Batch Name -->
                        <div>
                            <label for="batch_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Batch Name
                            </label>
                            <input type="text" 
                                   id="batch_name"
                                   wire:model="batch_name"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Optional batch name to group related options">
                            @error('batch_name') 
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
                                   wire:model="position"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Order position within batch (0 = first)">
                            @error('position') 
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                        </div>

                        <!-- Option Type -->
                        <div>
                            <label for="option_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Data Type *
                            </label>
                            <select id="option_type"
                                    wire:model.live="option_type"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="string">String</option>
                                <option value="json">JSON</option>
                                <option value="array">Array</option>
                                <option value="boolean">Boolean</option>
                                <option value="integer">Integer</option>
                                <option value="float">Float</option>
                            </select>
                            @error('option_type') 
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                        </div>

                        <!-- Option Flags -->
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="is_autoload"
                                       wire:model="is_autoload"
                                       class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                                <label for="is_autoload" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    Autoload (load automatically on app start)
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="is_system"
                                       wire:model="is_system"
                                       class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500">
                                <label for="is_system" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    System option (protected from deletion)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Option Value -->
                    <div>
                        <label for="option_value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Option Value
                            @if(in_array($option_type, ['json', 'array']))
                                <span class="text-xs text-gray-500 dark:text-gray-400">(JSON format required)</span>
                            @endif
                        </label>
                        
                        @if($option_type === 'boolean')
                            <select wire:model="option_value"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select value</option>
                                <option value="1">True</option>
                                <option value="0">False</option>
                            </select>
                        @elseif(in_array($option_type, ['json', 'array']))
                            <textarea id="option_value"
                                      wire:model="option_value"
                                      rows="6"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"
                                      placeholder='{"key": "value"} or ["item1", "item2"]'></textarea>
                        @else
                            <input type="{{ $option_type === 'integer' || $option_type === 'float' ? 'number' : 'text' }}" 
                                   id="option_value"
                                   wire:model="option_value"
                                   @if($option_type === 'float') step="any" @endif
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter option value">
                        @endif
                        
                        @error('option_value') 
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description"
                                  wire:model="description"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Optional description of what this option is used for"></textarea>
                        @error('description') 
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Data Type Help -->
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

                    <!-- Modal footer -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" 
                                wire:click="closeModal"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove>Create Option</span>
                            <span wire:loading class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
                                    <path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Creating...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>