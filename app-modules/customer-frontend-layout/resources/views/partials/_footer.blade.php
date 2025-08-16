<!-- Footer -->
<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Your Company</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                    Building innovative solutions for the digital world.
                </p>
                <div class="text-gray-600 dark:text-gray-400 text-sm space-y-2">
                    <p class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="mailto:info@yourcompany.com" class="hover:text-blue-600 dark:hover:text-blue-400">info@yourcompany.com</a>
                    </p>
                    <p class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <a href="tel:+1234567890" class="hover:text-blue-600 dark:hover:text-blue-400">+1 234 567 890</a>
                    </p>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Home</a></li>
                    <li><a href="{{ route('static-site::about') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">About</a></li>
                    <li><a href="{{ route('blog::blog.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Blog</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Services</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl('/contact') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Our Services</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Web Development</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Mobile Apps</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Consulting</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Support</a></li>
                </ul>
            </div>

            <!-- Office -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Office</h3>
                <div class="text-gray-600 dark:text-gray-400 text-sm space-y-2">
                    <p class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        123 Business Street<br>
                        City, State 12345
                    </p>
                    <p class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Mon - Fri: 9:00 AM - 6:00 PM
                    </p>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
            <!-- Payment Channel -->
            <div class="text-center mb-6">
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Secure Payment Powered by</h4>
                <div class="flex justify-center">
                    <div class="px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm text-gray-600 dark:text-gray-400">
                        SSL Secure Payment Gateway
                    </div>
                </div>
            </div>

            <!-- Legal Links -->
            <div class="flex flex-wrap justify-center items-center gap-4 md:gap-6 mb-4">
                <a href="{{ LaravelLocalization::localizeUrl('/pages/terms-of-service') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 text-sm transition-colors">
                    {{ __('messages.terms_of_service') }}
                </a>
                <span class="text-gray-400 dark:text-gray-600">•</span>
                <a href="{{ LaravelLocalization::localizeUrl('/pages/privacy-policy') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 text-sm transition-colors">
                    {{ __('messages.privacy_policy') }}
                </a>
                <span class="text-gray-400 dark:text-gray-600">•</span>
                <a href="{{ LaravelLocalization::localizeUrl('/pages/refund-policy') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 text-sm transition-colors">
                    {{ __('messages.refund_policy') }}
                </a>
                <span class="text-gray-400 dark:text-gray-600">•</span>
                <a href="{{ route('payment::custom-payment.form') }}" 
                   class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 text-sm transition-colors">
                    {{ __('messages.payment') }}
                </a>
            </div>
            
            <!-- Copyright -->
            <div class="text-center text-gray-500 dark:text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
                <p class="mt-1">{{ __('messages.open_24_7') }}</p>
            </div>
        </div>
    </div>
</footer>