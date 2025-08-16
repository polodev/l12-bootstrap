<x-admin-dashboard-layout::layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Admin Dashboard Layout Test</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Testing the admin dashboard layout component</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- Layout Features Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Layout Features</h3>
                <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                <li class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Sidebar Navigation
                </li>
                <li class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    User Profile Dropdown
                </li>
                <li class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Dark Mode Support
                </li>
                <li class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Responsive Design
                </li>
                <li class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Alpine.js Integration
                </li>
            </ul>
        </div>

        <!-- Navigation Test Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Navigation Test</h3>
                <div class="bg-purple-100 dark:bg-purple-900 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
            <div class="space-y-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">Test the sidebar navigation:</p>
                <ul class="space-y-1 text-sm">
                    <li><span class="text-blue-600 dark:text-blue-400">Dashboard</span> - Current page</li>
                    <li><span class="text-gray-600 dark:text-gray-400">Users</span> - User management</li>
                    <li><span class="text-gray-600 dark:text-gray-400">Roles</span> - Role management</li>
                    <li><span class="text-gray-600 dark:text-gray-400">Settings</span> - System settings</li>
                </ul>
                <p class="text-xs text-gray-500 dark:text-gray-500 mt-3">
                    Click the sidebar toggle button to test mobile navigation.
                </p>
            </div>
        </div>

        <!-- Component Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Component Info</h3>
                <div class="bg-green-100 dark:bg-green-900 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Module:</span>
                    <code class="ml-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs">admin-dashboard-layout</code>
                </div>
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Component:</span>
                    <code class="ml-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs">admin-dashboard-layout::layout</code>
                </div>
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Namespace:</span>
                    <code class="ml-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs">Modules\AdminDashboardLayout</code>
                </div>
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Usage:</span>
                    <code class="ml-1 px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs">&lt;x-admin-dashboard-layout::layout&gt;</code>
                </div>
            </div>
        </div>
    </div>

    <!-- Sample Content -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-800 dark:text-gray-200">Sample Admin Content</h2>
        </div>
        <div class="p-6">
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                This is sample content within the admin dashboard layout. You can see how the sidebar navigation works alongside the main content area.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-2">Layout Structure</h4>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                        <li>• Header with user profile</li>
                        <li>• Collapsible sidebar navigation</li>
                        <li>• Main content area (this section)</li>
                        <li>• Responsive mobile layout</li>
                    </ul>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h4 class="font-medium text-gray-800 dark:text-gray-200 mb-2">Integration</h4>
                    <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                        <li>• Works with existing auth system</li>
                        <li>• Supports localization</li>
                        <li>• Compatible with Tailwind CSS</li>
                        <li>• Uses Alpine.js for interactions</li>
                    </ul>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('test.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Test Index
                </a>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>