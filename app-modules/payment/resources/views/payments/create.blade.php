<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Create Custom Payment</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Create a custom payment record for manual transactions</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('payment::admin.payments.index') }}" 
                       class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                </div>
            </div>
        </div>

        <!-- Create Form -->
        <div class="p-6">
            <form method="POST" action="{{ route('payment::admin.payments.store_custom_payment') }}">
                @csrf

                @if($errors->has('general'))
                    <div class="mb-6 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 rounded-md p-4">
                        <div class="text-sm text-red-700 dark:text-red-300">{{ $errors->first('general') }}</div>
                    </div>
                @endif

                <!-- Hidden input for payment type -->
                <input type="hidden" name="payment_type" value="custom_payment">

                <!-- Required Fields Section -->
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 mb-6">
                    <h4 class="text-lg font-medium text-red-900 dark:text-red-100 mb-4">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        Required Information
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Customer Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Customer Mobile <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('mobile')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Amount <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="amount" name="amount" step="0.01" min="100" required
                                   value="{{ old('amount') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="100.00">
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Payment Method <span class="text-red-500">*</span>
                            </label>
                            <select id="payment_method" name="payment_method" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Select Method --</option>
                                @foreach(\Modules\Payment\Models\Payment::getAvailablePaymentMethods() as $value => $label)
                                    <option value="{{ $value }}" {{ old('payment_method') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Optional Fields Section -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Optional Information</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="email_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Customer Email
                            </label>
                            <input type="email" id="email_address" name="email_address" value="{{ old('email_address') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('email_address')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Purpose
                            </label>
                            <input type="text" id="purpose" name="purpose" value="{{ old('purpose') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('purpose')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Status
                            </label>
                            <select id="status" name="status"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @foreach(\Modules\Payment\Models\Payment::getAvailableStatuses() as $value => $label)
                                    <option value="{{ $value }}" {{ old('status', 'pending') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mt-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Customer Notes
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Customer-related notes or comments...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Admin Notes -->
                <div class="mt-6">
                    <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Admin Notes <span class="text-xs text-gray-500 dark:text-gray-400">(Internal use only)</span>
                    </label>
                    <textarea id="admin_notes" name="admin_notes" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Internal admin notes, processing details, follow-ups...">{{ old('admin_notes') }}</textarea>
                    @error('admin_notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('payment::admin.payments.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Create Custom Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // Amount validation
            const amountInput = document.getElementById('amount');
            const form = amountInput.closest('form');
            
            // Real-time validation
            amountInput.addEventListener('input', function() {
                const value = parseFloat(this.value);
                const errorElement = this.parentElement.querySelector('.text-red-600, .text-red-400');
                
                if (value < 100 && this.value !== '') {
                    this.classList.add('border-red-500');
                    this.classList.remove('border-gray-300', 'dark:border-gray-600');
                    
                    // Show error message if doesn't exist
                    if (!errorElement) {
                        const errorMsg = document.createElement('p');
                        errorMsg.className = 'mt-1 text-sm text-red-600 dark:text-red-400';
                        errorMsg.textContent = 'Amount must be at least ৳100.00';
                        this.parentElement.appendChild(errorMsg);
                    }
                } else {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-gray-300', 'dark:border-gray-600');
                    
                    // Remove error message if exists and was added by JS
                    if (errorElement && !errorElement.hasAttribute('data-server-error')) {
                        errorElement.remove();
                    }
                }
            });
            
            // Form submission validation
            form.addEventListener('submit', function(e) {
                const value = parseFloat(amountInput.value);
                
                if (value < 100) {
                    e.preventDefault();
                    amountInput.focus();
                    
                    // Show error if not already shown
                    const errorElement = amountInput.parentElement.querySelector('.text-red-600, .text-red-400');
                    if (!errorElement) {
                        const errorMsg = document.createElement('p');
                        errorMsg.className = 'mt-1 text-sm text-red-600 dark:text-red-400';
                        errorMsg.textContent = 'Amount must be at least ৳100.00';
                        amountInput.parentElement.appendChild(errorMsg);
                    }
                    
                    amountInput.classList.add('border-red-500');
                    return false;
                }
            });
            
            // Mark server errors so they don't get removed by JS
            const existingError = amountInput.parentElement.querySelector('.text-red-600, .text-red-400');
            if (existingError) {
                existingError.setAttribute('data-server-error', 'true');
            }
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>