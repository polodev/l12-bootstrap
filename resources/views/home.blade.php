<x-customer-frontend-layout::layout>
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    {{ __('messages.welcome') }}
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    Your Next Great Project Starts Here
                </p>
                <div class="space-x-4">
                    <a href="{{ route('static-site::about') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        Learn More
                    </a>
                    <a href="{{ route('payment::custom-payment.form') }}" class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('messages.services') }}
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Everything you need to build something great
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Web Development</h3>
                    <p class="text-gray-600 dark:text-gray-400">Modern, responsive web applications</p>
                </div>
                
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Mobile Apps</h3>
                    <p class="text-gray-600 dark:text-gray-400">Cross-platform mobile solutions</p>
                </div>
                
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364-.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Consulting</h3>
                    <p class="text-gray-600 dark:text-gray-400">Strategic technology guidance</p>
                </div>
                
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Support</h3>
                    <p class="text-gray-600 dark:text-gray-400">24/7 technical support</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Language Support Section -->
    <div class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Multilingual Support
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                    Available in multiple languages for a global audience
                </p>
                
                <!-- Language Switcher -->
                <div class="flex justify-center space-x-4 mb-8">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                           class="px-6 py-3 rounded-lg text-sm font-medium transition-colors {{ LaravelLocalization::getCurrentLocale() == $localeCode ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600' }}">
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
                
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <p>Current Language: <strong>{{ app()->getLocale() }}</strong></p>
                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>