<x-admin-dashboard-layout::layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Activity Log Details</h2>
                    <div class="flex items-center space-x-3">
                        <form action="{{ route('admin-dashboard.activity-logs.destroy', $activity) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this activity log? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-300 dark:border-red-600 rounded-md shadow-sm text-sm font-medium text-red-700 dark:text-red-300 bg-white dark:bg-gray-700 hover:bg-red-50 dark:hover:bg-red-900/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <i class="fas fa-trash mr-2"></i> Delete
                            </button>
                        </form>
                        <a href="{{ route('admin-dashboard.activity-logs.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Activity Logs
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Activity Information -->
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Activity Information</h3>
                            </div>
                            <div class="px-6 py-4 space-y-4">
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Activity ID:</span>
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $activity->id }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Activity Type:</span>
                                    <div class="mt-1">
                                        @php
                                            $badgeClasses = [
                                                'user' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                                'auth' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                                'admin' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                                'system' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300'
                                            ];
                                            $badgeClass = $badgeClasses[$activity->log_name] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                            {{ ucfirst($activity->log_name) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Description:</span>
                                    <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $activity->description }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Date & Time:</span>
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        <div>{{ $activity->created_at->format('M d, Y H:i:s') }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Changes Details -->
                        @if($activity->properties && (isset($activity->properties['attributes']) || isset($activity->properties['old'])))
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg mt-6">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Changes Made</h3>
                            </div>
                            <div class="px-6 py-4">
                                @php
                                    $properties = $activity->properties;
                                    $attributes = $properties['attributes'] ?? [];
                                    $old = $properties['old'] ?? [];
                                @endphp
                                
                                @if(count($attributes) > 0)
                                    <div class="space-y-4">
                                        @foreach($attributes as $key => $newValue)
                                            @php
                                                $oldValue = $old[$key] ?? null;
                                            @endphp
                                            @if($oldValue !== $newValue)
                                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                                        @if($key === 'email_verified_at')
                                                            @if($oldValue === null && $newValue !== null)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                                    <i class="fas fa-check mr-1"></i> Email Verified
                                                                </span>
                                                            @elseif($oldValue !== null && $newValue === null)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                                                    <i class="fas fa-times mr-1"></i> Email Unverified
                                                                </span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    
                                                    @if($key !== 'email_verified_at')
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div>
                                                                <span class="text-xs font-medium text-red-600 dark:text-red-400">Before:</span>
                                                                <div class="mt-1 p-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded text-sm text-red-700 dark:text-red-300">
                                                                    {{ $oldValue ?? 'null' }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <span class="text-xs font-medium text-green-600 dark:text-green-400">After:</span>
                                                                <div class="mt-1 p-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded text-sm text-green-700 dark:text-green-300">
                                                                    {{ $newValue ?? 'null' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No changes recorded</p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Sidebar with Actor and Subject Info -->
                    <div class="lg:col-span-1">
                        <!-- Performed By -->
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Performed By</h3>
                            </div>
                            <div class="px-6 py-4">
                                @if($activity->causer)
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                                <span class="text-blue-600 dark:text-blue-300 font-medium text-sm">
                                                    {{ $activity->causer->initials() }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $activity->causer->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $activity->causer->email }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Role: {{ ucfirst($activity->causer->role ?? 'None') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <a href="{{ route('admin-dashboard.users.show', $activity->causer->id) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <i class="fas fa-user mr-2"></i> View User
                                        </a>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-cog text-gray-400 dark:text-gray-500 text-2xl mb-2"></i>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">System Action</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Subject Information -->
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg mt-6">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Subject</h3>
                            </div>
                            <div class="px-6 py-4">
                                @if($activity->subject)
                                    <div class="space-y-3">
                                        <div>
                                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Type:</span>
                                            <p class="text-sm text-gray-900 dark:text-white">{{ class_basename($activity->subject_type) }}</p>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">ID:</span>
                                            <p class="text-sm text-gray-900 dark:text-white">{{ $activity->subject_id }}</p>
                                        </div>
                                        
                                        @if($activity->subject_type === 'App\\Models\\User')
                                            <div>
                                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Name:</span>
                                                <p class="text-sm text-gray-900 dark:text-white">{{ $activity->subject->name }}</p>
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Email:</span>
                                                <p class="text-sm text-gray-900 dark:text-white">{{ $activity->subject->email }}</p>
                                            </div>
                                            <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                                                <a href="{{ route('admin-dashboard.users.show', $activity->subject->id) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <i class="fas fa-external-link-alt mr-2"></i> View Subject
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-trash text-red-400 dark:text-red-500 text-2xl mb-2"></i>
                                        <p class="text-sm text-red-500 dark:text-red-400">Subject Deleted</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            Original Type: {{ class_basename($activity->subject_type) }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            Original ID: {{ $activity->subject_id }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Raw Data (for debugging) -->
                        @if($activity->properties && count($activity->properties) > 0)
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg mt-6">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Raw Properties</h3>
                            </div>
                            <div class="px-6 py-4">
                                <pre class="text-xs text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900 p-3 rounded border overflow-x-auto">{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>