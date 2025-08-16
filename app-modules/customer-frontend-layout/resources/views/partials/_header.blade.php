<!-- Customer Frontend Header -->
<header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="text-2xl font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                    Laravel 12
                </a>
            </div>

            <!-- Mobile Controls: Language, Theme, Auth, Menu -->
            @include('customer-frontend-layout::partials._mobile-controls')

            <!-- Desktop Navigation -->
            @include('customer-frontend-layout::partials._desktop-navigation')
        </div>

        <!-- Mobile Navigation Menu -->
        @include('customer-frontend-layout::partials._mobile-menu')
    </div>
</header>