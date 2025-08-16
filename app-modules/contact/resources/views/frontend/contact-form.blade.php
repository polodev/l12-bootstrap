<x-customer-frontend-layout::layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.contact_us') }}</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('messages.contact_form_subtitle') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Contact Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ __('messages.send_message') }}</h2>
                        
                        @if($errors->any())
                            <!-- Error Messages -->
                            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">{{ __('messages.please_fix_errors') }}:</h3>
                                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <form action="{{ route('contact::frontend.contacts.store') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <!-- Personal Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.full_name') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name ?? '') }}" required 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-500" 
                                           placeholder="{{ __('messages.enter_your_full_name') }}">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.email_address') }}
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-500" 
                                           placeholder="{{ __('messages.enter_your_email') }}">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Contact Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.mobile_number') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="mobile" id="mobile" value="{{ old('mobile') }}" required 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-500" 
                                           placeholder="{{ __('messages.enter_your_mobile') }}">
                                    @error('mobile')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.department') }}
                                    </label>
                                    <select name="department" id="department" 
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">{{ __('messages.select_department') }}</option>
                                        @foreach (\Modules\Contact\Models\Contact::getAvailableDepartments() as $key => $label)
                                            <option value="{{ $key }}" {{ old('department') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Organization Information - Temporarily commented out -->
                            {{-- 
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="organization" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.organization') }}
                                    </label>
                                    <input type="text" name="organization" id="organization" value="{{ old('organization') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-500" 
                                           placeholder="{{ __('messages.enter_organization') }}">
                                    @error('organization')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="designation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.designation') }}
                                    </label>
                                    <input type="text" name="designation" id="designation" value="{{ old('designation') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-500" 
                                           placeholder="{{ __('messages.enter_designation') }}">
                                    @error('designation')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            --}}
                            
                            <!-- Subject/Topic -->
                            <div>
                                <label for="topic" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.topic') }}
                                </label>
                                <input type="text" name="topic" id="topic" value="{{ old('topic') }}" 
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-500" 
                                       placeholder="{{ __('messages.enter_topic') }}">
                                @error('topic')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.message') }} <span class="text-red-500">*</span>
                                </label>
                                <textarea name="message" id="message" rows="6" required 
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-500" 
                                          placeholder="{{ __('messages.enter_your_message') }}">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Hidden Fields -->
                            <input type="hidden" name="page" value="{{ request()->url() }}">
                            @if(auth()->check())
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            @endif
                            
                            <!-- Privacy Notice -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700 dark:text-blue-300">
                                            <strong>Privacy Notice:</strong> Your personal information will be used solely to respond to your inquiry. We do not share your information with third parties.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- reCAPTCHA -->
                            @if(config('services.recaptcha.enabled', false))
                            <div class="pt-4">
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                @error('g-recaptcha-response')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif
                            
                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    {{ __('messages.send_message') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Contact Information Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mb-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">{{ __('messages.get_in_touch') }}</h3>
                        
                        <div class="space-y-6">
                            <!-- Phone Numbers -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.phone_numbers') }}</h4>
                                    <div class="text-gray-600 dark:text-gray-400 space-y-1">
                                        <p><a href="tel:+8809647668822" class="hover:text-blue-600 dark:hover:text-blue-400">+8809647668822</a> ({{ __('messages.main_office') }})</p>
                                        <p><a href="tel:01600366415" class="hover:text-blue-600 dark:hover:text-blue-400">01600366415</a></p>
                                        <p><a href="tel:01600366416" class="hover:text-blue-600 dark:hover:text-blue-400">01600366416</a></p>
                                        <p><a href="tel:01600366417" class="hover:text-blue-600 dark:hover:text-blue-400">01600366417</a></p>
                                        <p><a href="tel:01600366418" class="hover:text-blue-600 dark:hover:text-blue-400">01600366418</a></p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Email Support -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.email_support') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        <a href="mailto:info@ecotravelsonline.com.bd" class="hover:text-blue-600 dark:hover:text-blue-400">info@ecotravelsonline.com.bd</a>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Business Hours -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.business_hours') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ __('messages.open_24_7') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Branch Locations -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mb-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">{{ __('messages.our_locations') }}</h3>
                        
                        <div class="space-y-6">
                            <!-- Bangladesh Office -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.bangladesh_office') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ __('messages.bangladesh_address') }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- New Zealand Office -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.new_zealand_office') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ __('messages.new_zealand_address') }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Australia Office -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.australia_office') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ __('messages.australia_address') }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- India Office -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('messages.india_office') }}</h4>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ __('messages.india_address') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ Quick Links -->
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Quick Help</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Before sending a message, you might find your answer in our frequently asked questions.
                        </p>
                        <div class="text-sm">
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline block mb-2">• View FAQ</a>
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline block mb-2">• Service Information</a>
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline block">• Technical Support</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if(config('services.recaptcha.enabled', false))
        @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endpush
    @endif
</x-customer-frontend-layout::layout>