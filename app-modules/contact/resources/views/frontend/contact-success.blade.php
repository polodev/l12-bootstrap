<x-customer-frontend-layout::layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            <div class="text-center mb-12">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 dark:bg-green-900/20 mb-6">
                    <svg class="h-12 w-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.message_sent_successfully') }}</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('messages.thank_you_for_contacting') }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contact Summary -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ __('messages.your_message_details') }}</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.contact_reference') }}</label>
                            <p class="mt-1 text-lg font-mono text-blue-600 dark:text-blue-400">#{{ $contact->id }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Please keep this reference number for your records</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.name') }}</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $contact->name }}</p>
                        </div>
                        
                        @if($contact->email)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.email') }}</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $contact->email }}</p>
                        </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.mobile') }}</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $contact->mobile }}</p>
                        </div>
                        
                        @if($contact->organization)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.organization') }}</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $contact->organization }}</p>
                        </div>
                        @endif
                        
                        @if($contact->department)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.department') }}</label>
                            <div class="mt-1">{!! $contact->department_badge !!}</div>
                        </div>
                        @endif
                        
                        @if($contact->topic)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.topic') }}</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $contact->topic }}</p>
                        </div>
                        @endif
                        
                        @if($contact->message)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.message') }}</label>
                            <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600">
                                <p class="text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $contact->message }}</p>
                            </div>
                        </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.submitted_on') }}</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $contact->created_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- What's Next -->
                <div class="space-y-6">
                    <!-- What to Expect -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">{{ __('messages.what_happens_next') }}</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900/20">
                                        <span class="text-sm font-medium text-blue-600 dark:text-blue-400">1</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">Message Received</h4>
                                    <p class="text-gray-600 dark:text-gray-400">{{ __('messages.step_1') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-yellow-100 dark:bg-yellow-900/20">
                                        <span class="text-sm font-medium text-yellow-600 dark:text-yellow-400">2</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">Under Review</h4>
                                    <p class="text-gray-600 dark:text-gray-400">{{ __('messages.step_2') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-green-100 dark:bg-green-900/20">
                                        <span class="text-sm font-medium text-green-600 dark:text-green-400">3</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">We'll Get Back to You</h4>
                                    <p class="text-gray-600 dark:text-gray-400">{{ __('messages.step_3') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">What Would You Like to Do Next?</h3>
                        
                        <div class="space-y-3">
                            <a href="/" class="w-full inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                {{ __('messages.back_to_home') }}
                            </a>
                            
                            <a href="{{ route('contact::frontend.contacts.create') }}" class="w-full inline-flex items-center justify-center px-6 py-3 text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                {{ __('messages.send_another_message') }}
                            </a>
                        </div>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Need Immediate Assistance?</h3>
                        
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Email: support@example.com</span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Phone: +1 (555) 123-4567</span>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">Business Hours: Mon-Fri 9AM-6PM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>