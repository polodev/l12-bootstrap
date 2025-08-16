<x-customer-frontend-layout::layout>
    <div class="flex flex-col lg:flex-row gap-8" x-data="{ sidebarOpen: false }">
        <!-- Mobile Sidebar Toggle -->
        <div class="lg:hidden">
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="w-full flex items-center justify-between px-4 py-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <span class="font-medium">Account Menu</span>
                <svg class="w-5 h-5" :class="{ 'rotate-180': sidebarOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>

        <!-- Account Sidebar -->
        @include('customer-account-layout::partials._sidebar')

        <!-- Main Content -->
        <main class="flex-1">
            @include('customer-frontend-layout::partials._status-message')
            {{ $slot }}
        </main>
    </div>
</x-customer-frontend-layout::layout>