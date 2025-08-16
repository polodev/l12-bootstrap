<x-admin-dashboard-layout::layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">Admin Dashboard</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">Welcome to the Admin Dashboard. Manage users, roles, and system settings.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 border-2 border-blue-200 dark:border-blue-700 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-blue-100 dark:bg-blue-900 rounded-full">
                            <i class="fas fa-users text-3xl text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <h5 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">User Management</h5>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Manage system users, roles, and permissions.</p>
                        <a href="{{ route('admin-dashboard.users.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Manage Users
                        </a>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 border-2 border-cyan-200 dark:border-cyan-700 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-cyan-100 dark:bg-cyan-900 rounded-full">
                            <i class="fas fa-chart-bar text-3xl text-cyan-600 dark:text-cyan-400"></i>
                        </div>
                        <h5 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Reports</h5>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">View system reports and analytics.</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
                            View Reports
                        </a>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 border-2 border-green-200 dark:border-green-700 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center bg-green-100 dark:bg-green-900 rounded-full">
                            <i class="fas fa-cog text-3xl text-green-600 dark:text-green-400"></i>
                        </div>
                        <h5 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Settings</h5>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Configure system settings and preferences.</p>
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            System Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>
