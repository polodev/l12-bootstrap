<x-customer-account-layout::layout>
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('accounts.index') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('accounts.settings.profile') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('messages.profile') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('messages.edit') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('messages.edit_profile') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.update_name_only') }}</p>
    </div>

    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar Navigation -->
            @include('customer-dashboard::settings.partials.navigation')

            <!-- Profile Content -->
            <div class="flex-1">
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
                    <div class="p-6">
                        <!-- Profile Form -->
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200">
                                {{ __('messages.profile_information') }}
                            </h2>
                            <a href="{{ route('accounts.settings.profile') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('messages.cancel') }}
                            </a>
                        </div>

                        <form class="max-w-md mb-10" action="{{ route('accounts.settings.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Avatar Section -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    {{ __('messages.profile_photo') }}
                                </label>
                                
                                <!-- Current Avatar Display -->
                                <div class="flex items-center mb-4">
                                    <div class="relative">
                                        @if($user->getFirstMedia('avatar'))
                                            <img src="{{ $user->avatar_url }}" 
                                                 alt="{{ $user->name }}"
                                                 class="w-20 h-20 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                                                 id="avatar-preview">
                                        @else
                                            <div class="w-20 h-20 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium text-xl border-2 border-gray-200 dark:border-gray-600"
                                                 id="avatar-preview">
                                                {{ $user->initials() }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('messages.upload_new_photo') }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500">
                                            JPG, PNG or GIF (max 2MB)
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- File Input -->
                                <div class="mb-4">
                                    <input type="file" 
                                           name="avatar" 
                                           id="avatar"
                                           accept="image/*"
                                           class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300 dark:hover:file:bg-blue-800">
                                    @error('avatar')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Remove Avatar Option (only if avatar exists) -->
                                @if($user->getFirstMedia('avatar'))
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               name="remove_avatar" 
                                               id="remove_avatar"
                                               class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                        <label for="remove_avatar" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('messages.remove_current_photo') }}
                                        </label>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="mb-4">
                                <x-forms.input :label="__('messages.name')" name="name" type="text"
                                    value="{{ old('name', $user->name) }}" />
                            </div>





                            <div>
                                <x-button type="primary">{{ __('messages.save') }}</x-button>
                            </div>
                        </form>

                        <!-- Delete Account Section -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-1">
                                {{ __('messages.delete_account') }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                {{ __('messages.delete_account_resources') }}
                            </p>
                            <form action="{{ route('accounts.settings.profile.destroy') }}" method="POST"
                                onsubmit="return confirm('{{ __('messages.are_you_sure_delete') }}')">
                                @csrf
                                @method('DELETE')
                                <x-button type="danger">{{ __('messages.delete_account') }}</x-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('avatar-preview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Replace the current avatar with image
                    preview.innerHTML = '';
                    preview.className = 'w-20 h-20 rounded-full border-2 border-gray-200 dark:border-gray-600';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview';
                    img.className = 'w-20 h-20 rounded-full object-cover';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Reset preview if remove avatar is checked
        document.getElementById('remove_avatar')?.addEventListener('change', function(e) {
            const preview = document.getElementById('avatar-preview');
            const fileInput = document.getElementById('avatar');
            
            if (e.target.checked) {
                // Show initials preview
                preview.innerHTML = '{{ Auth::user()->initials() }}';
                preview.className = 'w-20 h-20 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium text-xl border-2 border-gray-200 dark:border-gray-600';
                fileInput.value = '';
            }
        });
    </script>
    @endpush
</x-customer-account-layout::layout>