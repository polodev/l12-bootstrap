<x-customer-frontend-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white mb-4">
                Customer Frontend Layout Test
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                Testing the customer frontend layout component with public navigation and features.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Layout Features Card -->
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Layout Features</h3>
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Public Navigation
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Language Switcher
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Authentication Links
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Footer Section
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Responsive Design
                    </li>
                </ul>
            </div>

            <!-- Localization Test Card -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Localization Test</h3>
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="space-y-3">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Test the language switcher in the header:</p>
                    
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-2 bg-white dark:bg-gray-700 rounded">
                            <span class="text-sm">Current Language:</span>
                            <strong class="text-sm text-blue-600 dark:text-blue-400">{{ app()->getLocale() }}</strong>
                        </div>
                        
                        <div class="flex items-center justify-between p-2 bg-white dark:bg-gray-700 rounded">
                            <span class="text-sm">Available:</span>
                            <span class="text-xs text-gray-500">English & Bangla</span>
                        </div>
                    </div>
                    
                    <p class="text-xs text-gray-500 dark:text-gray-500">
                        Use the language switcher in the header to test localization.
                    </p>
                </div>
            </div>

            <!-- Component Info Card -->
            <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-700 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Component Info</h3>
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Module:</span>
                        <code class="ml-1 px-2 py-1 bg-white dark:bg-gray-700 rounded text-xs">customer-frontend-layout</code>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Component:</span>
                        <code class="ml-1 px-2 py-1 bg-white dark:bg-gray-700 rounded text-xs">customer-frontend-layout::layout</code>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Namespace:</span>
                        <code class="ml-1 px-2 py-1 bg-white dark:bg-gray-700 rounded text-xs">Modules\CustomerFrontendLayout</code>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 dark:text-gray-300">Usage:</span>
                        <code class="ml-1 px-2 py-1 bg-white dark:bg-gray-700 rounded text-xs">&lt;x-customer-frontend-layout::layout&gt;</code>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sample Public Content -->
        <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 rounded-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">Sample Public Content</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                This is sample content within the customer frontend layout. Perfect for public-facing pages like home, about, contact, and other marketing pages.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-3">Navigation Features</h4>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            Clean header with branding
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            Language switcher for EN/BN
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            Authentication state handling
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            Mobile-responsive navigation
                        </li>
                    </ul>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-3">Use Cases</h4>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-2">
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                            Homepage and landing pages
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                            Authentication pages (login/register)
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                            Public content pages
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                            Marketing and informational pages
                        </li>
                    </ul>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('test.index') }}" class="inline-flex items-center px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Test Index
                </a>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>