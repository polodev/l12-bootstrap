<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Create Coupon</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Add a new discount coupon for subscription plans</p>
                </div>
                <a href="{{ route('coupon::admin.coupons.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('coupon::admin.coupons.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Basic Information -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Coupon Code -->
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Coupon Code *
                            </label>
                            <input type="text" 
                                   id="code"
                                   name="code"
                                   value="{{ old('code') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 uppercase"
                                   placeholder="e.g., SAVE20, WELCOME"
                                   style="text-transform: uppercase;"
                                   required>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Enter a unique code that customers will use</p>
                            @error('code')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Coupon Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Coupon Name *
                            </label>
                            <input type="text" 
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., 20% Off Welcome Discount"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Brief description of the coupon (optional)">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Discount Configuration -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Discount Configuration</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Discount Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Discount Type *
                            </label>
                            <select id="type" 
                                    name="type"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">Select Type</option>
                                <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed Amount (BDT)</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Discount Value -->
                        <div>
                            <label for="value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <span id="value-label">Discount Value *</span>
                            </label>
                            <input type="number" 
                                   id="value"
                                   name="value"
                                   value="{{ old('value') }}"
                                   step="0.01"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., 20 or 100"
                                   required>
                            <p id="value-help" class="mt-1 text-xs text-gray-500 dark:text-gray-400">Enter the discount amount</p>
                            @error('value')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Maximum Discount (for percentage) -->
                        <div id="max-discount-field" style="display: none;">
                            <label for="maximum_discount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Maximum Discount (BDT)
                            </label>
                            <input type="number" 
                                   id="maximum_discount"
                                   name="maximum_discount"
                                   value="{{ old('maximum_discount') }}"
                                   step="0.01"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., 500">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Max discount amount for percentage coupons</p>
                            @error('maximum_discount')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Minimum Amount -->
                        <div>
                            <label for="minimum_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Minimum Order Amount (BDT)
                            </label>
                            <input type="number" 
                                   id="minimum_amount"
                                   name="minimum_amount"
                                   value="{{ old('minimum_amount') }}"
                                   step="0.01"
                                   min="0"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., 100">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimum amount required to use this coupon</p>
                            @error('minimum_amount')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Usage Limits -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Usage Limits</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Total Usage Limit -->
                        <div>
                            <label for="usage_limit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Total Usage Limit
                            </label>
                            <input type="number" 
                                   id="usage_limit"
                                   name="usage_limit"
                                   value="{{ old('usage_limit') }}"
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., 100">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maximum number of times this coupon can be used (leave empty for unlimited)</p>
                            @error('usage_limit')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Usage Limit Per User -->
                        <div>
                            <label for="usage_limit_per_user" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Usage Limit Per User
                            </label>
                            <input type="number" 
                                   id="usage_limit_per_user"
                                   name="usage_limit_per_user"
                                   value="{{ old('usage_limit_per_user') }}"
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="e.g., 1">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maximum times a single user can use this coupon (leave empty for unlimited)</p>
                            @error('usage_limit_per_user')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Applicable Plans -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Applicable Plans</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Select which subscription plans this coupon can be applied to:
                        </label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input id="all_plans" 
                                       name="all_plans" 
                                       type="checkbox" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                       {{ empty(old('applicable_plans')) ? 'checked' : '' }}>
                                <label for="all_plans" class="ml-2 block text-sm text-gray-700 dark:text-gray-300 font-medium">
                                    All Plans (Default)
                                </label>
                            </div>
                            
                            <div id="specific-plans" class="mt-4 ml-6 space-y-2" style="{{ empty(old('applicable_plans')) ? 'display: none;' : '' }}">
                                @foreach($subscriptionPlans as $plan)
                                    <div class="flex items-center">
                                        <input id="plan_{{ $plan->id }}" 
                                               name="applicable_plans[]" 
                                               type="checkbox" 
                                               value="{{ $plan->id }}"
                                               {{ in_array($plan->id, old('applicable_plans', [])) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded plan-checkbox">
                                        <label for="plan_{{ $plan->id }}" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            {{ $plan->getTranslation('plan_title', 'en') }} - {{ $plan->formatted_price }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @error('applicable_plans')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Validity Period -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Validity Period</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Start Date -->
                        <div>
                            <label for="starts_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Start Date
                            </label>
                            <input type="datetime-local" 
                                   id="starts_at"
                                   name="starts_at"
                                   value="{{ old('starts_at') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">When this coupon becomes active (leave empty for immediate)</p>
                            @error('starts_at')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="expires_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Expiry Date
                            </label>
                            <input type="datetime-local" 
                                   id="expires_at"
                                   name="expires_at"
                                   value="{{ old('expires_at') }}"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">When this coupon expires (leave empty for no expiry)</p>
                            @error('expires_at')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Status</h3>
                    <div class="flex items-center">
                        <input id="is_active" 
                               name="is_active" 
                               type="checkbox" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Active Coupon
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Uncheck to create an inactive coupon that can be activated later</p>
                    @error('is_active')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('coupon::admin.coupons.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Coupon
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const valueLabel = document.getElementById('value-label');
            const valueHelp = document.getElementById('value-help');
            const maxDiscountField = document.getElementById('max-discount-field');
            const allPlansCheckbox = document.getElementById('all_plans');
            const specificPlansDiv = document.getElementById('specific-plans');
            const planCheckboxes = document.querySelectorAll('.plan-checkbox');

            // Handle discount type change
            function updateDiscountFields() {
                const selectedType = typeSelect.value;
                
                if (selectedType === 'percentage') {
                    valueLabel.textContent = 'Percentage (%) *';
                    valueHelp.textContent = 'Enter percentage (e.g., 20 for 20%)';
                    maxDiscountField.style.display = 'block';
                } else if (selectedType === 'fixed') {
                    valueLabel.textContent = 'Fixed Amount (BDT) *';
                    valueHelp.textContent = 'Enter fixed discount amount in BDT';
                    maxDiscountField.style.display = 'none';
                } else {
                    valueLabel.textContent = 'Discount Value *';
                    valueHelp.textContent = 'Enter the discount amount';
                    maxDiscountField.style.display = 'none';
                }
            }

            typeSelect.addEventListener('change', updateDiscountFields);
            updateDiscountFields(); // Initialize on page load

            // Auto-generate coupon code
            const codeInput = document.getElementById('code');
            codeInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });

            // Handle plan selection
            allPlansCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    specificPlansDiv.style.display = 'none';
                    planCheckboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                } else {
                    specificPlansDiv.style.display = 'block';
                }
            });

            // If any specific plan is checked, uncheck "All Plans"
            planCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        allPlansCheckbox.checked = false;
                        specificPlansDiv.style.display = 'block';
                    } else {
                        // If no plans are selected, check "All Plans"
                        const anyChecked = Array.from(planCheckboxes).some(cb => cb.checked);
                        if (!anyChecked) {
                            allPlansCheckbox.checked = true;
                            specificPlansDiv.style.display = 'none';
                        }
                    }
                });
            });

            // Set minimum date to today for start and end dates
            const now = new Date();
            const today = now.toISOString().slice(0, 16);
            document.getElementById('starts_at').min = today;
            document.getElementById('expires_at').min = today;

            // Update end date minimum when start date changes
            document.getElementById('starts_at').addEventListener('change', function() {
                document.getElementById('expires_at').min = this.value;
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>