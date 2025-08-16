<x-customer-account-layout::layout>
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('accounts.index') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('messages.addresses') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('messages.addresses') }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.manage_your_addresses') }}</p>
        </div>
        <a href="{{ route('accounts.addresses.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            {{ __('messages.add_new_address') }}
        </a>
    </div>

    <!-- Address Content -->
    <div class="space-y-6">
                @if($addresses->isEmpty())
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('messages.no_addresses') }}</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('messages.no_addresses_description') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('accounts.addresses.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('messages.add_your_first_address') }}
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Addresses Grid -->
                    <div class="grid gap-6 md:grid-cols-2">
                        @foreach($addresses as $address)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center space-x-2">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $address->name }}
                                            </h3>
                                            @if($address->is_default)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                    {{ __('messages.default') }}
                                                </span>
                                            @endif
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            {{ ucfirst($address->type) }}
                                        </span>
                                    </div>

                                    <div class="text-gray-600 dark:text-gray-400 space-y-1">
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $address->contact_name }}</p>
                                        <p>{{ $address->contact_phone }}</p>
                                        <p>{{ $address->full_address }}</p>
                                    </div>

                                    <div class="mt-6 flex space-x-3">
                                        <a href="{{ route('accounts.addresses.edit', $address) }}"
                                            class="text-sm bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-3 py-2 rounded-md transition-colors">
                                            {{ __('messages.edit') }}
                                        </a>
                                        
                                        @if(!$address->is_default)
                                            <form action="{{ route('accounts.addresses.set-default', $address) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-sm bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 px-3 py-2 rounded-md transition-colors">
                                                    {{ __('messages.set_as_default') }}
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('accounts.addresses.destroy', $address) }}" method="POST" class="inline"
                                            onsubmit="return confirm('{{ __('messages.are_you_sure_delete_address') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-sm bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:hover:bg-red-800 text-red-700 dark:text-red-300 px-3 py-2 rounded-md transition-colors">
                                                {{ __('messages.delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
    </div>
</x-customer-account-layout::layout>