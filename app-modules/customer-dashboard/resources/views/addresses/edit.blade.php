<x-customer-account-layout::layout>
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('accounts.index') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('accounts.addresses.index') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.addresses') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('messages.edit_address') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('messages.edit_address') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.edit_address_description') }}</p>
    </div>

    <!-- Address Form -->
    <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <form action="{{ route('accounts.addresses.update', $address) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('messages.address_type') }}
                                    </label>
                                    <select name="type" id="type" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                        <option value="home" {{ old('type', $address->type) === 'home' ? 'selected' : '' }}>{{ __('messages.home') }}</option>
                                        <option value="work" {{ old('type', $address->type) === 'work' ? 'selected' : '' }}>{{ __('messages.work') }}</option>
                                        <option value="other" {{ old('type', $address->type) === 'other' ? 'selected' : '' }}>{{ __('messages.other') }}</option>
                                    </select>
                                    @error('type')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <x-forms.input :label="__('messages.address_name')" name="name" type="text"
                                        value="{{ old('name', $address->name) }}" required placeholder="{{ __('messages.address_name_placeholder') }}" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-forms.input :label="__('messages.contact_name')" name="contact_name" type="text"
                                        value="{{ old('contact_name', $address->contact_name) }}" required />
                                </div>

                                <div>
                                    <x-forms.input :label="__('messages.contact_phone')" name="contact_phone" type="text"
                                        value="{{ old('contact_phone', $address->contact_phone) }}" required />
                                </div>
                            </div>

                            <div>
                                <label for="address_line_1" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.address_line_1') }}
                                </label>
                                <textarea name="address_line_1" id="address_line_1" rows="2" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                    placeholder="{{ __('messages.address_line_1_placeholder') }}">{{ old('address_line_1', $address->address_line_1) }}</textarea>
                                @error('address_line_1')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="address_line_2" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.address_line_2') }} <span class="text-gray-500">({{ __('messages.optional') }})</span>
                                </label>
                                <textarea name="address_line_2" id="address_line_2" rows="2"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                    placeholder="{{ __('messages.address_line_2_placeholder') }}">{{ old('address_line_2', $address->address_line_2) }}</textarea>
                                @error('address_line_2')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <x-forms.input :label="__('messages.city')" name="city" type="text"
                                        value="{{ old('city', $address->city) }}" required />
                                </div>

                                <div>
                                    <x-forms.input :label="__('messages.state')" name="state" type="text"
                                        value="{{ old('state', $address->state) }}" required />
                                </div>

                                <div>
                                    <x-forms.input :label="__('messages.postal_code')" name="postal_code" type="text"
                                        value="{{ old('postal_code', $address->postal_code) }}" required />
                                </div>
                            </div>

                            <div>
                                <x-forms.input :label="__('messages.country')" name="country" type="text"
                                    value="{{ old('country', $address->country) }}" required />
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_default" id="is_default" value="1" 
                                    {{ old('is_default', $address->is_default) ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                <label for="is_default" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    {{ __('messages.set_as_default_address') }}
                                </label>
                            </div>

                            <div class="flex justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('accounts.addresses.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('messages.cancel') }}
                                </a>
                                <x-button type="primary">{{ __('messages.update_address') }}</x-button>
                            </div>
                        </form>
                    </div>
                </div>
    </div>
</x-customer-account-layout::layout>