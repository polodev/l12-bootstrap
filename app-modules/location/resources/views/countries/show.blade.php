<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @if($country->flag_url)
                        <img src="{{ $country->flag_url }}" alt="{{ $country->name }}" class="w-12 h-8 rounded border">
                    @endif
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $country->name }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Country Details</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('location::admin.countries.edit', $country->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('location::admin.countries.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Basic Information -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Country Name</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $country->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</label>
                                <div class="mt-1">{!! $country->status_badge !!}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ISO 2-Letter Code</label>
                                <p class="mt-1 text-sm font-mono font-medium text-gray-900 dark:text-gray-100">{{ $country->code }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ISO 3-Letter Code</label>
                                <p class="mt-1 text-sm font-mono font-medium text-gray-900 dark:text-gray-100">{{ $country->code_3 }}</p>
                            </div>
                            @if($country->phone_code)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Phone Code</label>
                                <p class="mt-1 text-sm font-mono font-medium text-gray-900 dark:text-gray-100">+{{ $country->phone_code }}</p>
                            </div>
                            @endif
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Display Position</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $country->position }}</p>
                            </div>
                        </div>
                    </div>

                    @if($country->currency_code || $country->currency_symbol)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Currency Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($country->currency_code)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Currency Code</label>
                                <p class="mt-1 text-sm font-mono font-medium text-gray-900 dark:text-gray-100">{{ $country->currency_code }}</p>
                            </div>
                            @endif
                            @if($country->currency_symbol)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Currency Symbol</label>
                                <p class="mt-1 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $country->currency_symbol }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($country->latitude || $country->longitude)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Location Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($country->latitude)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Latitude</label>
                                <p class="mt-1 text-sm font-mono font-medium text-gray-900 dark:text-gray-100">{{ $country->latitude }}</p>
                            </div>
                            @endif
                            @if($country->longitude)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Longitude</label>
                                <p class="mt-1 text-sm font-mono font-medium text-gray-900 dark:text-gray-100">{{ $country->longitude }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Related Data -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Related Data</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Cities -->
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">Cities ({{ $country->cities->count() }})</h4>
                                    <a href="{{ route('location::admin.cities.index') }}?country_id={{ $country->id }}" class="text-xs text-blue-600 hover:text-blue-800">View All</a>
                                </div>
                                @if($country->cities->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($country->cities->take(5) as $city)
                                            <div class="flex items-center justify-between py-1">
                                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $city->name }}</span>
                                            </div>
                                        @endforeach
                                        @if($country->cities->count() > 5)
                                            <p class="text-xs text-gray-500 pt-1">and {{ $country->cities->count() - 5 }} more...</p>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No cities added yet</p>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('location::admin.cities.create') }}?country_id={{ $country->id }}" class="block w-full text-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                Add City
                            </a>
                        </div>
                    </div>

                    <!-- Meta Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Meta Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</label>
                                <p class="mt-1 text-sm font-mono text-gray-900 dark:text-gray-100">{{ $country->id }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $country->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            @if($country->updated_at && $country->updated_at != $country->created_at)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $country->updated_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>