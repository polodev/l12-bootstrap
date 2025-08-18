<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Filter Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Support Tickets</h2>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600" id="filter_area_controller">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                        </svg>
                        Toggle Filters
                    </button>
                    <button id="bulkActionsBtn" class="hidden inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Bulk Actions
                    </button>
                    <a href="{{ route('support-ticket::admin.tickets.stats') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Statistics
                    </a>
                </div>
            </div>
            
            <div id="filter_area" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-3" style="display: block;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label for="status_filter" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
                        <select id="status_filter" class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <option value="">All Statuses</option>
                            <option value="new">New</option>
                            <option value="open">Open</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <div>
                        <label for="priority_filter" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Priority</label>
                        <select id="priority_filter" class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <option value="">All Priorities</option>
                            <option value="low">Low</option>
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                    <div>
                        <label for="ticket_creation_date_range" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Creation Date Range</label>
                        <input class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" type="text" name="ticket_creation_date_range" id="ticket_creation_date_range" placeholder="Select date range">
                    </div>
                    <div>
                        <label for="search_text" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Quick Search</label>
                        <input class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" type="text" name="search_text" id="search_text" placeholder="Search tickets...">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- DataTable Container -->
        <div class="overflow-hidden">
            <table id="tickets-table" class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ticket</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ticket Info</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Assigned</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Last Answered</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- DataTables will populate this -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bulk Actions Modal -->
    <div id="bulkModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">Bulk Actions</h3>
                        <div class="mt-4">
                            <select id="bulkAction" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select Action</option>
                                <option value="assign">Assign to Staff</option>
                                <option value="status">Change Status</option>
                                <option value="priority">Change Priority</option>
                            </select>
                            <div id="bulkValue" class="mt-3 hidden">
                                <select id="bulkValueSelect" class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <!-- Options will be populated dynamically -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="button" id="executeBulkAction" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Execute
                    </button>
                    <button type="button" id="closeBulkModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    $(document).ready(function() {
        // Toggle filter area
        $('#filter_area_controller').on('click', function() {
            const filterArea = $('#filter_area');
            if (filterArea.is(':visible')) {
                filterArea.slideUp();
            } else {
                filterArea.slideDown();
            }
        });
        // Initialize DataTable
        let table = $('#tickets-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('support-ticket::admin.tickets.json') }}',
                data: function(d) {
                    d.search_text = $('#search_text').val();
                    d.status = $('#status_filter').val();
                    d.priority = $('#priority_filter').val();
                    d.category = $('#category_filter').val();
                    d.assigned_to = $('#assigned_filter').val();
                }
            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return '<input type="checkbox" class="ticket-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="' + data + '">';
                    }
                },
                {data: 'formatted_id', name: 'formatted_id', orderable: false, searchable: false},
                {data: 'ticket_info', name: 'ticket_info', orderable: false, searchable: false},
                {data: 'customer_info', name: 'customer_info', orderable: false, searchable: false},
                {data: 'status_badge', name: 'status', searchable: false},
                {data: 'priority_badge', name: 'priority', searchable: false},
                {data: 'category_badge', name: 'category', searchable: false},
                {data: 'assigned_info', name: 'assigned_to', searchable: false},
                {data: 'last_answered', name: 'last_answered', orderable: false, searchable: false},
                {data: 'created_at_formatted', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            order: [[9, 'desc']],
            pageLength: 25,
            dom: '<"flex justify-between items-center mb-4"<"flex items-center space-x-2"l><"flex items-center space-x-2"f>>rtip',
            language: {
                search: "",
                searchPlaceholder: "Search tickets...",
                lengthMenu: "_MENU_ per page"
            }
        });

        // Filter handlers
        $('#search_text, #status_filter, #priority_filter, #category_filter, #assigned_filter').on('change keyup', function() {
            table.draw();
        });

        // Select all checkbox
        $('#select-all').on('change', function() {
            $('.ticket-checkbox').prop('checked', this.checked);
            toggleBulkActions();
        });

        // Individual checkbox handler
        $(document).on('change', '.ticket-checkbox', function() {
            toggleBulkActions();
            
            // Update select all checkbox
            const totalCheckboxes = $('.ticket-checkbox').length;
            const checkedCheckboxes = $('.ticket-checkbox:checked').length;
            $('#select-all').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
            $('#select-all').prop('checked', checkedCheckboxes === totalCheckboxes);
        });

        function toggleBulkActions() {
            const checkedBoxes = $('.ticket-checkbox:checked').length;
            if (checkedBoxes > 0) {
                $('#bulkActionsBtn').removeClass('hidden');
            } else {
                $('#bulkActionsBtn').addClass('hidden');
            }
        }

        // Bulk actions modal
        $('#bulkActionsBtn').on('click', function() {
            $('#bulkModal').removeClass('hidden');
        });

        $('#closeBulkModal').on('click', function() {
            $('#bulkModal').addClass('hidden');
        });

        $('#bulkAction').on('change', function() {
            const action = $(this).val();
            const valueDiv = $('#bulkValue');
            const valueSelect = $('#bulkValueSelect');
            
            if (action === 'assign' || action === 'status' || action === 'priority') {
                let options = '';
                
                if (action === 'status') {
                    options = '<option value="new">New</option><option value="open">Open</option><option value="in_progress">In Progress</option><option value="resolved">Resolved</option><option value="closed">Closed</option>';
                } else if (action === 'priority') {
                    options = '<option value="low">Low</option><option value="normal">Normal</option><option value="high">High</option><option value="urgent">Urgent</option>';
                } else if (action === 'assign') {
                    options = '<option value="{{ auth()->id() }}">Assign to Me</option><option value="">Unassign</option>';
                }
                
                valueSelect.html(options);
                valueDiv.removeClass('hidden');
            } else {
                valueDiv.addClass('hidden');
            }
        });

        $('#executeBulkAction').on('click', function() {
            const action = $('#bulkAction').val();
            const value = $('#bulkValueSelect').val();
            const ticketIds = $('.ticket-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (!action || ticketIds.length === 0) {
                alert('Please select an action and at least one ticket.');
                return;
            }


            $.ajax({
                url: '{{ route('support-ticket::admin.tickets.bulk-update') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    action: action,
                    value: value,
                    ticket_ids: ticketIds
                },
                success: function(response) {
                    if (response.success) {
                        table.draw();
                        $('#bulkModal').addClass('hidden');
                        $('#bulkActionsBtn').addClass('hidden');
                        alert(response.message);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while processing bulk action.');
                }
            });
        });

    });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>