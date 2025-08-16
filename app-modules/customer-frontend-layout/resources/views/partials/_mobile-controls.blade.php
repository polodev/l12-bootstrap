<div class="flex items-center space-x-3 md:hidden">
    <!-- Mobile Language Switcher -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
            <span class="text-xs font-medium">{{ LaravelLocalization::getCurrentLocale() == 'en' ? 'EN' : 'BN' }}</span>
            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        <div x-show="open" @click.away="open = false" x-transition
             class="absolute right-0 mt-2 w-20 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                   class="block px-3 py-2 text-xs {{ LaravelLocalization::getCurrentLocale() == $localeCode ? 'text-eco-green font-medium' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200' }} transition-colors">
                    {{ $localeCode == 'en' ? 'English' : 'বাংলা' }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Mobile Theme Switcher -->
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </button>
        <div x-show="open" @click.away="open = false" x-transition
             class="absolute right-0 mt-2 w-24 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700">
            <button onclick="setAppearance('light')" class="block w-full text-left px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Light</button>
            <button onclick="setAppearance('dark')" class="block w-full text-left px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Dark</button>
            <button onclick="setAppearance('system')" class="block w-full text-left px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">System</button>
        </div>
    </div>

    <!-- Mobile Auth -->
    @guest
        <a href="{{ route('login') }}" class="text-eco-green hover:text-eco-green-dark font-medium transition-colors text-xs">
            Login
        </a>
    @else
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition-colors">
                <span class="relative flex h-7 w-7 shrink-0 overflow-hidden rounded-full">
                    <span class="flex h-full w-full items-center justify-center rounded-full bg-eco-green text-white text-xs font-medium">
                        {{ Auth::user()->initials() }}
                    </span>
                </span>
            </button>
            
            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute right-0 mt-2 w-36 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700">
                <a href="{{ route('accounts.index') }}" class="block px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    {{ __('messages.my_account') }}
                </a>
                @if(auth()->check() && auth()->user()->hasAnyRole(['developer', 'admin', 'employee', 'accounts']))
                    <a href="{{ route('admin-dashboard.index') }}" class="block px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        {{ __('messages.admin_dashboard') }}
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    @endauth

    <!-- Mobile menu button -->
    <button @click="mobileMenuOpen = !mobileMenuOpen" 
            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
</div>