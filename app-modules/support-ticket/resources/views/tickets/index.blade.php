<x-customer-account-layout::layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.support_tickets') }}
            </h2>
            <a href="{{ route('support-ticket::tickets.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                {{ __('messages.create_ticket') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Search and Filter -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-end gap-4">
                        <!-- Search Tickets -->
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.search_tickets') }}</label>
                            <input type="text" id="search" 
                                   placeholder="{{ __('messages.search_tickets') }}..." 
                                   class="w-full px-4 py-2.5 text-sm border-2 border-blue-300 rounded-lg bg-white dark:bg-gray-700 dark:border-blue-600 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">
                        </div>
                        
                        <!-- Filter by Status -->
                        <div class="md:w-64">
                            <label for="status_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.filter_by_status') }}</label>
                            <select id="status_filter" class="w-full px-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">{{ __('messages.all_statuses') }}</option>
                                <option value="new">{{ __('messages.ticket_status_new') }}</option>
                                <option value="open">{{ __('messages.ticket_status_open') }}</option>
                                <option value="in_progress">{{ __('messages.ticket_status_in_progress') }}</option>
                                <option value="resolved">{{ __('messages.ticket_status_resolved') }}</option>
                                <option value="closed">{{ __('messages.ticket_status_closed') }}</option>
                            </select>
                        </div>
                        
                        <!-- Create New Ticket Button -->
                        <div class="md:w-auto">
                            <label class="block text-sm font-medium text-transparent mb-2">&nbsp;</label>
                            <a href="{{ route('support-ticket::tickets.create') }}" 
                               class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ __('messages.create_ticket') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets List -->
            @if($tickets->count() > 0)
            <div class="space-y-4" id="tickets-container">
                @foreach($tickets as $ticket)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 truncate">
                                        <a href="{{ route('support-ticket::tickets.show', $ticket) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                            #{{ $ticket->id }} - {{ $ticket->title }}
                                        </a>
                                    </h3>
                                    <div class="flex space-x-2">
                                        {!! $ticket->status_badge !!}
                                        {!! $ticket->priority_badge !!}
                                    </div>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 space-x-4">
                                    @if($ticket->category)
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        {!! $ticket->category_badge !!}
                                    </div>
                                    @endif
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        {!! $ticket->getLastAnsweredBadge('customer') !!}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $ticket->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        <span>{{ $ticket->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex flex-col space-y-2">
                                <a href="{{ route('support-ticket::tickets.show', $ticket) }}" 
                                   class="inline-flex items-center px-3 py-1 border border-blue-300 shadow-sm text-xs font-medium rounded text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    {{ __('messages.view') }}
                                </a>
                                
                                @if($ticket->isClosed())
                                <form action="{{ route('support-ticket::tickets.reopen', $ticket) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 border border-green-300 shadow-sm text-xs font-medium rounded text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        {{ __('messages.reopen_ticket') }}
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('support-ticket::tickets.close', $ticket) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_close_ticket', ['id' => $ticket->id]) }}')">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 border border-red-300 shadow-sm text-xs font-medium rounded text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        {{ __('messages.close_ticket') }}
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="bg-white dark:bg-gray-800 px-4 py-3 sm:px-6 rounded-lg shadow-sm">
                {{ $tickets->links() }}
            </div>

            @else
            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('messages.no_tickets_found') }}</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto">
                        {{ __('messages.need_help_question') }}<br>
                        {{ __('messages.create_ticket_description') }}
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('support-ticket::tickets.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{ __('messages.create_your_first_ticket') }}
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
            const searchInput = document.getElementById('search');
            const statusFilter = document.getElementById('status_filter');
            let searchTimeout;

            // Search functionality
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    performSearch();
                }, 300);
            });

            statusFilter.addEventListener('change', function() {
                performSearch();
            });

            function performSearch() {
                const searchTerm = searchInput.value;
                const statusValue = statusFilter.value;
                
                // Build query string
                const params = new URLSearchParams();
                if (searchTerm) params.append('q', searchTerm);
                if (statusValue) params.append('status', statusValue);
                
                // Make AJAX request
                fetch(`{{ route('support-ticket::tickets.search') }}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('tickets-container').innerHTML = data.html;
                        // Update pagination if provided
                        if (data.pagination) {
                            // Update pagination container if it exists
                            const paginationContainer = document.querySelector('.pagination');
                            if (paginationContainer && paginationContainer.parentElement) {
                                paginationContainer.parentElement.innerHTML = data.pagination;
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                });
            }

            // Auto-refresh every 30 seconds for status updates
            setInterval(function() {
                // Only refresh if not actively typing
                if (!searchInput.matches(':focus')) {
                    performSearch();
                }
            }, 30000);
        });
    </script>
    @endpush
</x-customer-account-layout::layout>