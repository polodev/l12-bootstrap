<div class="w-full md:w-64 shrink-0 border-r border-gray-200 dark:border-gray-700 pr-4">
    <nav class="bg-gray-50 dark:bg-gray-800 rounded-lg overflow-hidden">
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            <li>
                <a href="{{ route('accounts.settings.profile') }}" @class([
                    'bg-gray-100 dark:bg-gray-700 block px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600' => !request()->routeIs(
                        'accounts.settings.profile.*'),
                    'bg-white dark:bg-gray-600 block px-4 py-3  text-gray-900 dark:text-gray-100 font-medium' => request()->routeIs(
                        'accounts.settings.profile.*'),
                ])>
                    {{ __('Profile') }}
                </a>
            </li>
            <li>
                <a href="{{ route('accounts.settings.password.edit') }}" @class([
                    'bg-gray-100 dark:bg-gray-700 block px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600' => !request()->routeIs(
                        'accounts.settings.password.*'),
                    'bg-white dark:bg-gray-600  block px-4 py-3 text-gray-900 dark:text-gray-100 font-medium' => request()->routeIs(
                        'accounts.settings.password.*'),
                ])>
                    {{ __('Password') }}
                </a>
            </li>
            <li>
                <a href="{{ route('accounts.settings.appearance.edit') }}" @class([
                    'bg-gray-100 dark:bg-gray-700 block px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-600' => !request()->routeIs(
                        'accounts.settings.appearance.*'),
                    'bg-white dark:bg-gray-600 block px-4 py-3  text-gray-900 dark:text-gray-100 font-medium' => request()->routeIs(
                        'accounts.settings.appearance.*'),
                ])>
                    {{ __('Appearance') }}
                </a>
            </li>
        </ul>
    </nav>
</div>
