<x-admin-dashboard-layout::layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('support-ticket::admin.tickets.show', $ticket) }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Edit Ticket #{{ $ticket->id }}
                </h2>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('support-ticket::admin.tickets.show', $ticket) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Cancel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">There were errors with your submission</h3>
                                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('support-ticket::admin.tickets.update', $ticket) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Current Status Display -->
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">Current Status</h3>
                            <div class="flex flex-wrap gap-3">
                                {!! $ticket->status_badge !!}
                                {!! $ticket->priority_badge !!}
                                @if($ticket->category)
                                    {!! $ticket->category_badge !!}
                                @endif
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    @if($ticket->assignedTo)
                                        Assigned to {{ $ticket->assignedTo->name }}
                                    @else
                                        Unassigned
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ticket Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $ticket->title) }}" required
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select name="status" id="status" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach(\Modules\SupportTicket\Models\SupportTicket::getAvailableStatuses() as $statusKey => $statusLabel)
                                        <option value="{{ $statusKey }}" {{ old('status', $ticket->status) === $statusKey ? 'selected' : '' }}>
                                            {{ $statusLabel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Priority -->
                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Priority</label>
                                <select name="priority" id="priority" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach(\Modules\SupportTicket\Models\SupportTicket::getAvailablePriorities() as $priorityKey => $priorityLabel)
                                        <option value="{{ $priorityKey }}" {{ old('priority', $ticket->priority) === $priorityKey ? 'selected' : '' }}>
                                            {{ $priorityLabel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('priority')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                <select name="category" id="category"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Category</option>
                                    @foreach(\Modules\SupportTicket\Models\SupportTicket::getAvailableCategories() as $categoryKey => $categoryLabel)
                                        <option value="{{ $categoryKey }}" {{ old('category', $ticket->category) === $categoryKey ? 'selected' : '' }}>
                                            {{ $categoryLabel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Assigned To -->
                            <div>
                                <label for="assigned_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assign To</label>
                                <select name="assigned_to" id="assigned_to"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Unassigned</option>
                                    @foreach($assignableUsers as $user)
                                        <option value="{{ $user->id }}" {{ old('assigned_to', $ticket->assigned_to) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                (Me)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('assigned_to')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea name="description" id="description" rows="6" required
                                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $ticket->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Change Notes -->
                        <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Status Change Notes</h3>
                                    <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Changing status to <strong>"Resolved"</strong> or <strong>"Closed"</strong> will automatically set the closed date.</li>
                                            <li>Changing from closed status back to open will clear the closed date.</li>
                                            <li>Status changes are logged in the activity history.</li>
                                            <li>Customers will be notified of status changes (if notifications are enabled).</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information (Read-only) -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">Customer Information</h3>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $ticket->user->name }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            <a href="mailto:{{ $ticket->user->email }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                {{ $ticket->user->email }}
                                            </a>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            {{ $ticket->created_at->format('M d, Y H:i') }}
                                            <span class="text-gray-500 dark:text-gray-400">({{ $ticket->created_at->diffForHumans() }})</span>
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Messages</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $ticket->messages->count() }} messages</dd>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 flex items-center justify-end space-x-4">
                            <a href="{{ route('support-ticket::admin.tickets.show', $ticket) }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md text-sm font-medium">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium">
                                Update Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Activity -->
            @if($ticket->activities->count() > 0)
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Recent Activity</h3>
                    <div class="space-y-3">
                        @foreach($ticket->activities->take(5) as $activity)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="h-8 w-8 rounded-full bg-gray-100 dark:bg-gray-600 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $activity->description }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $activity->created_at->diffForHumans() }}
                                    @if($activity->causer)
                                        by {{ $activity->causer->name }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin-dashboard.activity-logs.index', ['subject_type' => 'Modules\\SupportTicket\\Models\\SupportTicket', 'subject_id' => $ticket->id]) }}" 
                           class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                            View All Activity →
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const currentStatus = '{{ $ticket->status }}';
            
            statusSelect.addEventListener('change', function() {
                const newStatus = this.value;
                
                // Show confirmation for major status changes
                if ((currentStatus !== 'closed' && newStatus === 'closed') || 
                    (currentStatus !== 'resolved' && newStatus === 'resolved')) {
                    if (!confirm(`Are you sure you want to change the status to "${this.options[this.selectedIndex].text}"? This action will mark the ticket as complete.`)) {
                        this.value = currentStatus;
                        return false;
                    }
                }
                
                // Show warning when reopening closed ticket
                if ((currentStatus === 'closed' || currentStatus === 'resolved') && 
                    (newStatus === 'new' || newStatus === 'open' || newStatus === 'in_progress')) {
                    if (!confirm(`This will reopen a previously closed ticket. Are you sure you want to continue?`)) {
                        this.value = currentStatus;
                        return false;
                    }
                }
            });

            // Auto-suggest assignment based on status
            const prioritySelect = document.getElementById('priority');
            const assignedToSelect = document.getElementById('assigned_to');
            
            prioritySelect.addEventListener('change', function() {
                if (this.value === 'urgent' && assignedToSelect.value === '') {
                    if (confirm('This is marked as urgent priority. Would you like to assign it to yourself?')) {
                        assignedToSelect.value = '{{ auth()->id() }}';
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>