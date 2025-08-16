<x-customer-frontend-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white mb-6">
                Layout Testing Module
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                Test all the modular layout components created for the application.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <!-- Admin Dashboard Layout -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-6">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Admin Dashboard Layout</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Test the admin dashboard layout with sidebar navigation and admin features.</p>
                        <a href="{{ route('test.admin-dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                            <span>Test Layout</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Customer Frontend Layout -->
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-6">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-500 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Customer Frontend Layout</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Test the public frontend layout with navigation and language switcher.</p>
                        <a href="{{ route('test.customer-frontend') }}" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                            <span>Test Layout</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Customer Account Layout -->
                <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-700 rounded-lg p-6">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-purple-500 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Customer Account Layout</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Test the customer account layout with account sidebar and profile features.</p>
                        <a href="{{ route('test.customer-account') }}" class="inline-flex items-center px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600 transition-colors">
                            <span>Test Layout</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Available Test Routes</h2>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                        <li><code class="bg-white dark:bg-gray-800 px-2 py-1 rounded">/test</code> - This index page</li>
                        <li><code class="bg-white dark:bg-gray-800 px-2 py-1 rounded">/test/admin-dashboard</code> - Admin Dashboard Layout Test</li>
                        <li><code class="bg-white dark:bg-gray-800 px-2 py-1 rounded">/test/customer-frontend</code> - Customer Frontend Layout Test</li>
                        <li><code class="bg-white dark:bg-gray-800 px-2 py-1 rounded">/test/customer-account</code> - Customer Account Layout Test</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-customer-frontend-layout::layout>