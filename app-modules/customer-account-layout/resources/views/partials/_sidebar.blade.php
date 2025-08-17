<aside class="lg:w-64 flex-shrink-0" x-show="sidebarOpen || window.innerWidth >= 1024" x-transition x-cloak x-init="if (window.innerWidth >= 1024) sidebarOpen = true">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6">
            <!-- User Profile Section -->
            <div class="flex items-center mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full">
                    @if(Auth::user()->getFirstMedia('avatar'))
                        <img src="{{ Auth::user()->avatar_url }}" 
                             alt="{{ Auth::user()->name }}"
                             class="h-full w-full rounded-full object-cover">
                    @else
                        <span class="flex h-full w-full items-center justify-center rounded-full bg-eco-green text-white font-medium">
                            {{ Auth::user()->initials() }}
                        </span>
                    @endif
                </span>
                <div class="ml-3 min-w-0 flex-1">
                    <p class="font-medium text-gray-900 dark:text-gray-100 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 break-all">{{ Auth::user()->email }}</p>
                </div>
            </div>
            
            <!-- Account Navigation -->
            <nav class="space-y-1">
                <a href="{{ route('accounts.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors group {{ request()->routeIs('accounts.index') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V7"></path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('accounts.settings.profile') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors group {{ request()->routeIs('accounts.settings.profile*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="font-medium">Profile</span>
                </a>
                
                <a href="{{ route('accounts.addresses.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors group {{ request()->routeIs('accounts.addresses.*') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-medium">Addresses</span>
                </a>
                
                <a href="{{ route('accounts.orders') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors group {{ request()->routeIs('accounts.orders') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="font-medium">Orders</span>
                </a>
                
                <a href="{{ route('accounts.subscription') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors group {{ request()->routeIs('accounts.subscription') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">Subscription</span>
                </a>
                
                <a href="{{ route('accounts.wishlist') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors group {{ request()->routeIs('accounts.wishlist') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span class="font-medium">Wishlist</span>
                </a>
                
                <a href="{{ route('accounts.support') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors group {{ request()->routeIs('accounts.support') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                    </svg>
                    <span class="font-medium">Support</span>
                </a>
                
                <a href="{{ route('accounts.settings.profile.edit') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors group {{ request()->routeIs('accounts.settings.profile.edit') ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : '' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-medium">Settings</span>
                </a>
            </nav>
        </div>
    </div>
</aside>