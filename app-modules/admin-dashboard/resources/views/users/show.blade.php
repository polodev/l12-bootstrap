<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">User Details</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('admin-dashboard.users.edit', $user) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit User
                    </a>
                    <a href="{{ route('admin-dashboard.users.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">User Information</h3>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    ID:
                                </div>
                                <div class="sm:col-span-2 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $user->id }}
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Name:
                                </div>
                                <div class="sm:col-span-2 text-sm text-gray-900 dark:text-gray-100 font-medium">
                                    {{ $user->name }}
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Email:
                                </div>
                                <div class="sm:col-span-2 text-sm text-gray-900 dark:text-gray-100">
                                    <a href="mailto:{{ $user->email }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                                        {{ $user->email }}
                                    </a>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Country:
                                </div>
                                <div class="sm:col-span-2 text-sm text-gray-900 dark:text-gray-100">
                                    @if($user->country)
                                        @php
                                            $countryName = \Modules\UserData\Helpers\CountryListWithCountryCode::getCountryName($user->country);
                                        @endphp
                                        {{ $countryName ?? $user->country }}
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">Not specified</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Mobile:
                                </div>
                                <div class="sm:col-span-2 text-sm text-gray-900 dark:text-gray-100">
                                    @if($user->mobile)
                                        <a href="tel:{{ $user->country_code }}{{ $user->mobile }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                                            {{ $user->country_code }}{{ $user->mobile }}
                                        </a>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">Not provided</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Role:
                                </div>
                                <div class="sm:col-span-2">
                                    @if($user->role)
                                        @php
                                            $badgeClasses = [
                                                'developer' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                                'admin' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                                'employee' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
                                                'accounts' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                                'customer' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
                                            ];
                                            $badgeClass = $badgeClasses[$user->role] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                            {{ Str::headline($user->role) }}
                                        </span>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">No role assigned</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Email Verified:
                                </div>
                                <div class="sm:col-span-2">
                                    @if($user->email_verified_at)
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Verified
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $user->email_verified_at->format('Y-m-d H:i:s') }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Not Verified
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Mobile Verified:
                                </div>
                                <div class="sm:col-span-2">
                                    @if($user->mobile_verified_at)
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Verified
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $user->mobile_verified_at ? $user->mobile_verified_at->format('Y-m-d H:i:s') : '' }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Not Verified
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Created:
                                </div>
                                <div class="sm:col-span-2">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $user->created_at->format('Y-m-d H:i:s') }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $user->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Last Updated:
                                </div>
                                <div class="sm:col-span-2">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $user->updated_at->format('Y-m-d H:i:s') }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $user->updated_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                    Last Login:
                                </div>
                                <div class="sm:col-span-2">
                                    @if($user->last_login_at)
                                        <div class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $user->last_login_at->format('Y-m-d H:i:s') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $user->last_login_at->diffForHumans() }}
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Never logged in</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Avatar and Quick Actions -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Profile</h3>
                        </div>
                        <div class="px-6 py-4 text-center">
                            <div class="mx-auto w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center mb-4">
                                <span class="text-2xl font-bold text-white">
                                    {{ $user->initials() }}
                                </span>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</h4>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $user->email }}</p>
                            @if($user->role)
                                <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">{{ Str::headline($user->role) }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Quick Actions</h3>
                        </div>
                        <div class="px-6 py-4 space-y-2">
                            <a href="{{ route('admin-dashboard.users.edit', $user) }}" class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit User
                            </a>
                            
                            @if(!$user->email_verified_at)
                                <button type="button" onclick="verifyEmail({{ $user->id }})" class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Verify Email
                                </button>
                            @endif
                            
                            @if($user->mobile && !$user->mobile_verified_at)
                                <button type="button" onclick="verifyMobile({{ $user->id }})" class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md hover:bg-purple-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    Verify Mobile
                                </button>
                            @endif
                            
                            @if(!in_array($user->role, ['developer', 'admin']))
                                <button type="button" onclick="deleteUser({{ $user->id }})" class="w-full inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete User
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function verifyEmail(userId) {
            if (confirm('Are you sure you want to verify this user\'s email?')) {
                fetch(`/admin/users/${userId}/verify-email`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to show updated verification status
                        window.location.reload();
                    } else {
                        alert('Error verifying email: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while verifying the email.');
                });
            }
        }

        function verifyMobile(userId) {
            if (confirm('Are you sure you want to verify this user\'s mobile number?')) {
                fetch(`/admin/users/${userId}/verify-mobile`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to show updated verification status
                        window.location.reload();
                    } else {
                        alert('Error verifying mobile: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while verifying the mobile number.');
                });
            }
        }

        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                // Add your delete logic here
                fetch(`/admin/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '{{ route("admin-dashboard.users.index") }}';
                    } else {
                        alert('Error deleting user: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the user.');
                });
            }
        }
    </script>
    @endpush
</x-admin-dashboard-layout::layout>