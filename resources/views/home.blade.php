<x-customer-frontend-layout::layout>
    <!-- Hero Section -->
    <section class="relative bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="pt-16 pb-12 md:pt-20 md:pb-16 lg:pt-24 lg:pb-20">
                <div class="text-center max-w-4xl mx-auto">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 dark:text-white mb-8">
                        Laravel 12 Bootstrap
                    </h1>
                    <p class="text-lg sm:text-xl md:text-2xl text-gray-600 dark:text-gray-400 mb-12 max-w-3xl mx-auto leading-relaxed">
                        A modern Laravel starter project with modular architecture, multi-language support, and built-in authentication
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="{{ route('static-site::about') }}" 
                           class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            Learn More
                        </a>
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center justify-center border-2 border-blue-600 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white font-semibold px-8 py-4 rounded-lg transition-all duration-200 transform hover:scale-105">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom border -->
        <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-gray-200 dark:via-gray-700 to-transparent"></div>
    </section>

    <!-- Features Section -->
    <div class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Features Included
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Built-in features to accelerate your development
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Modular Architecture</h3>
                    <p class="text-gray-600 dark:text-gray-400">Clean, organized module structure</p>
                </div>
                
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Multi-Language</h3>
                    <p class="text-gray-600 dark:text-gray-400">English & Bengali localization</p>
                </div>
                
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Dark Mode</h3>
                    <p class="text-gray-600 dark:text-gray-400">Built-in theme switching</p>
                </div>
                
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Authentication</h3>
                    <p class="text-gray-600 dark:text-gray-400">Complete auth system</p>
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