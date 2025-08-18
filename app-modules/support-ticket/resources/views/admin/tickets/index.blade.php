<x-admin-dashboard-layout::layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Support Tickets
            </h2>
            <div class="flex space-x-3">
                <button id="bulkActionsBtn" class="hidden bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Bulk Actions
                </button>
                <a href="{{ route('support-ticket::admin.tickets.stats') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Statistics
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filters Bar -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-end gap-4">
                        <!-- Search Tickets -->
                        <div class="flex-1">
                            <label for="search_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search Tickets</label>
                            <input type="text" id="search_text" 
                                   placeholder="Search Tickets..." 
                                   class="w-full px-4 py-2.5 text-sm border-2 border-blue-300 rounded-lg bg-white dark:bg-gray-700 dark:border-blue-600 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out">
                        </div>
                        
                        <!-- Filter by Status -->
                        <div class="lg:w-48">
                            <label for="status_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Status</label>
                            <select id="status_filter" class="w-full px-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Statuses</option>
                                <option value="new">New</option>
                                <option value="open">Open</option>
                                <option value="in_progress">In Progress</option>
                                <option value="resolved">Resolved</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                        
                        <!-- Additional Filters (Hidden by default) -->
                        <div class="hidden lg:w-48" id="priority-filter-container">
                            <label for="priority_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Priority</label>
                            <select id="priority_filter" class="w-full px-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Priorities</option>
                                <option value="low">Low</option>
                                <option value="normal">Normal</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        
                        <div class="hidden lg:w-48" id="category-filter-container">
                            <label for="category_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                            <select id="category_filter" class="w-full px-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Categories</option>
                                <option value="general">General</option>
                                <option value="technical">Technical</option>
                                <option value="billing">Billing</option>
                                <option value="feature_request">Feature Request</option>
                                <option value="bug_report">Bug Report</option>
                                <option value="account">Account</option>
                            </select>
                        </div>
                        
                        <div class="hidden lg:w-48" id="assigned-filter-container">
                            <label for="assigned_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assigned To</label>
                            <select id="assigned_filter" class="w-full px-3 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Staff</option>
                                <option value="unassigned">Unassigned</option>
                                <option value="{{ auth()->id() }}">Assigned to Me</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tickets Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table id="tickets-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ticket</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ticket Info</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Priority</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Assigned</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Messages</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <!-- DataTables will populate this -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
                {data: 'messages_count', name: 'messages_count', orderable: false, searchable: false},
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