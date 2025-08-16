<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('customer-frontend-layout::partials._head')
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased">
    
    @include('customer-frontend-layout::partials._header')

    <!-- Main Content -->
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </div>
    </div>

    @include('customer-frontend-layout::partials._footer')

    @include('customer-frontend-layout::partials._status-message')

    @include('customer-frontend-layout::partials._scripts')
</body>

</html>