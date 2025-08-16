<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Filter Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">User Management</h2>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600" id="filter_area_controller">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                        </svg>
                        Toggle Filters
                    </button>
                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700" id="clear_all_filter_button">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear Filters
                    </button>
                    <a href="{{ route('admin-dashboard.users.create') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add User
                    </a>
                </div>
            </div>
            
            <div id="filter_area" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-3" style="display: block;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label for="role" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Role</label>
                        <select multiple class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="role[]" id="role">
                            @foreach ($roles as $role)
                                <option value="{{ $role }}">{{ Str::headline($role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="email_verified" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Email Verification</label>
                        <select class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="email_verified" id="email_verified">
                            <option value="">All Users</option>
                            <option value="verified">Verified</option>
                            <option value="unverified">Unverified</option>
                        </select>
                    </div>
                    <div>
                        <label for="user_creation_date_range" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Creation Date Range</label>
                        <input class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" type="text" name="user_creation_date_range" id="user_creation_date_range" placeholder="Select date range">
                    </div>
                    <div>
                        <label for="search_text" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Quick Search</label>
                        <input class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" type="text" name="search_text" id="search_text" placeholder="Search by name, email...">
                    </div>
                </div>
                <div class="mt-2">
                    <div class="flex items-center">
                        <input class="h-3 w-3 text-blue-600 border-gray-300 dark:border-gray-600 rounded" type="checkbox" id="storing_filter_data" checked>
                        <label class="ml-2 text-xs text-gray-700 dark:text-gray-300" for="storing_filter_data">
                            Remember filter settings
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hidden date inputs for DataTables -->
        <input type="hidden" id="starting_date_of_user_create_at">
        <input type="hidden" id="ending_date_of_user_created_at">
        
        <!-- DataTable Info -->
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
            <div id="datatable-info-custom" class="text-xs text-gray-600 dark:text-gray-400"></div>
        </div>
        
        <!-- Multi-select Actions -->
        <div id="multi-select-actions" class="px-4 py-2 bg-blue-50 dark:bg-blue-900 border-b border-blue-200 dark:border-blue-700" style="display: none;">
            <div class="flex justify-between items-center">
                <span class="text-blue-800 dark:text-blue-200 text-xs">
                    <strong><span id="number_of_row_selected_text">0</span></strong> users selected
                </span>
                <div class="flex space-x-1">
                    <button type="button" class="px-2 py-1 text-xs text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-600" id="remove_selection_button">
                        Clear Selection
                    </button>
                    <button type="button" class="px-2 py-1 text-xs text-white bg-blue-600 border border-transparent rounded hover:bg-blue-700" id="all_selection_button">
                        Select All
                    </button>
                    <button type="button" class="px-2 py-1 text-xs text-white bg-yellow-600 border border-transparent rounded hover:bg-yellow-700" id="bulk_update_role_button">
                        Update Role
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Export Buttons Section -->
        @if(auth()->user()->hasAnyRole(['developer', 'admin']))
            <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600" id="export-buttons-section" style="display: none;">
                <div class="flex flex-wrap gap-2" id="export-buttons-container">
                    <!-- Export buttons will be moved here by JavaScript -->
                </div>
            </div>
        @endif
        
        <!-- DataTable Container -->
        <div class="overflow-hidden">
            <table id="user-table" class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <!-- DataTables will handle thead and tbody -->
            </table>
        </div>
        
        <!-- Page Navigation -->
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center space-x-1 max-w-xs">
                <input type="number" value="1" class="flex-1 px-2 py-1 text-xs border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" id="datatable-page-number">
                <button id="datatable-page-number-button" class="px-2 py-1 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-600" type="button">
                    Go To Page
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const current_route_name = 'admin-dashboard.users.index';
        
        $(document).ready(function() {
            // DataTable configuration with backend-driven columns
            var userTable = $('#user-table').DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 500,
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100, 200],
                scrollX: true,
                autoWidth: false,
                responsive: false,
                ajax: {
                    url: '{{ route('admin-dashboard.users.json') }}',
                    type: "POST",
                    data: function(d) {
                        d.role = $('#role').val();
                        d.email_verified = $('#email_verified').val();
                        d.starting_date_of_user_create_at = $('#starting_date_of_user_create_at').val();
                        d.ending_date_of_user_created_at = $('#ending_date_of_user_created_at').val();
                        d.search_text = $('#search_text').val();
                    }
                },
                columns: [
                    {
                        data: 'id_formatted',
                        name: 'id',
                        title: 'ID',
                        searchable: true,
                        orderable: true,
                        className: 'text-center w-20'
                    },
                    {
                        data: 'created_at_formatted',
                        name: 'created_at',
                        title: 'Created At',
                        searchable: false,
                        orderable: true,
                        className: 'w-32'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        title: 'Name',
                        searchable: true,
                        className: 'font-medium'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        title: 'Email',
                        searchable: true,
                        className: 'text-gray-600 dark:text-gray-400'
                    },
                    {
                        data: 'email_verified_badge',
                        name: 'email_verified_at',
                        title: 'Verified',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-24'
                    },
                    {
                        data: 'role_badge',
                        name: 'role',
                        title: 'Role',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-28'
                    },
                    {
                        data: 'last_login_formatted',
                        name: 'last_login_at',
                        title: 'Last Login',
                        searchable: false,
                        orderable: true,
                        className: 'w-32'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Actions',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-32'
                    }
                ],
                order: [[1, 'desc']],
                language: {
                    search: "Search users:",
                    lengthMenu: "Show _MENU_ users per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ users",
                    infoEmpty: "No users found",
                    infoFiltered: "(filtered from _MAX_ total users)",
                    processing: '<div class="flex items-center justify-center"><svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle><path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="ml-2">Loading...</span></div>'
                },
                @if(auth()->user()->hasAnyRole(['developer', 'admin']))
                    buttons: [
                        {
                            extend: 'csv',
                            className: 'dt-button',
                            text: '<i class="fas fa-file-csv mr-1"></i> CSV',
                            title: 'Users Export'
                        },
                        {
                            extend: 'excel',
                            className: 'dt-button',
                            text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                            title: 'Users Export'
                        },
                        {
                            extend: 'pdf',
                            className: 'dt-button',
                            text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                            title: 'Users Export',
                            orientation: 'landscape'
                        }
                    ],
                    dom: 'B<"flex flex-row justify-between items-center mb-2 gap-2"lf>rtip',
                @else
                    dom: '<"flex flex-row justify-between items-center mb-2 gap-2"lf>rtip',
                @endif
                drawCallback: function() {
                    // Apply Tailwind styles after draw
                    $('#user-table').addClass('divide-y divide-gray-200 dark:divide-gray-700');
                    $('#user-table thead').addClass('bg-gray-50 dark:bg-gray-700');
                    $('#user-table thead th').addClass('px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider');
                    $('#user-table tbody').addClass('bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700');
                    $('#user-table tbody td').addClass('px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100');
                    
                    // Enhanced pagination styling
                    $('.dataTables_paginate .paginate_button').each(function() {
                        var $btn = $(this);
                        
                        // Remove any inline styles that might interfere
                        $btn.removeAttr('style');
                        
                        // Add our custom classes
                        if ($btn.hasClass('disabled')) {
                            $btn.addClass('opacity-40 cursor-not-allowed bg-gray-100 dark:bg-gray-900 text-gray-400 dark:text-gray-600 border-gray-200 dark:border-gray-800');
                        } else if ($btn.hasClass('current')) {
                            $btn.addClass('bg-blue-600 text-white border-blue-600 shadow-md');
                        } else {
                            $btn.addClass('bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600');
                        }
                    });
                    
                    // Ensure proper styling for length and filter controls
                    $('.dataTables_length select, .dataTables_filter input').each(function() {
                        const $element = $(this);
                        $element.removeAttr('style');
                        if ($element.is('select')) {
                            $element.addClass('mx-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500');
                        } else {
                            $element.addClass('ml-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-500');
                        }
                    });
                }
            });
            
            // Multi-select functionality
            $('#user-table tbody').on('click', 'tr', function() {
                $(this).toggleClass('selected bg-blue-100 dark:bg-blue-800');
                updateTextForNumberOfSelectedRows();
            });
            
            $('#remove_selection_button').on('click', function() {
                $('#user-table tbody tr').removeClass('selected bg-blue-100 dark:bg-blue-800');
                updateTextForNumberOfSelectedRows();
            });
            
            $('#all_selection_button').on('click', function() {
                $('#user-table tbody tr').addClass('selected bg-blue-100 dark:bg-blue-800');
                updateTextForNumberOfSelectedRows();
            });
            
            function updateTextForNumberOfSelectedRows() {
                var selectedCount = $('#user-table tbody tr.selected').length;
                $('#number_of_row_selected_text').text(selectedCount);
                
                if (selectedCount > 0) {
                    $('#multi-select-actions').show();
                } else {
                    $('#multi-select-actions').hide();
                }
            }
            
            // Initialize Select2 for role filter
            $('#role').select2({
                placeholder: "Select roles to filter",
                allowClear: true,
                closeOnSelect: false,
                theme: 'default',
                width: '100%'
            });
            
            // Initialize date range picker
            $('#user_creation_date_range').flatpickr({
                mode: "range",
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        const startDate = flatpickr.formatDate(selectedDates[0], "Y-m-d");
                        const endDate = flatpickr.formatDate(selectedDates[1], "Y-m-d");
                        $('#starting_date_of_user_create_at').val(startDate);
                        $('#ending_date_of_user_created_at').val(endDate);
                        userTable.draw();
                    }
                },
                onReady: function(dateObj, dateStr, instance) {
                    var $cal = $(instance.calendarContainer);
                    if ($cal.find('.flatpickr-clear').length < 1) {
                        $cal.append('<div class="flatpickr-clear">Clear</div>');
                        $cal.find('.flatpickr-clear').on('click', function() {
                            instance.clear();
                            instance.close();
                            $('#starting_date_of_user_create_at').val('');
                            $('#ending_date_of_user_created_at').val('');
                            userTable.draw();
                        });
                    }
                }
            });
            
            // Page navigation
            dataTableNavigate(userTable);
            
            // Filter change listeners
            var filterElements = [
                '#role',
                '#email_verified',
                '#starting_date_of_user_create_at',
                '#ending_date_of_user_created_at'
            ];
            
            // Local storage for filter persistence
            const storingFilterDataCheckbox = $('#storing_filter_data');
            const storing_filter_data_local_forage_key = 'storing_filter_data_users';
            
            // Retrieve checkbox state from localStorage
            if (localStorage.getItem(storing_filter_data_local_forage_key) !== null) {
                storingFilterDataCheckbox.prop('checked', localStorage.getItem(storing_filter_data_local_forage_key) === 'true');
            }
            
            // Save checkbox state
            storingFilterDataCheckbox.on('change', function() {
                localStorage.setItem(storing_filter_data_local_forage_key, storingFilterDataCheckbox.is(':checked'));
            });
            
            filterElements.forEach(function(element) {
                // Load saved filter values
                setTimeout(function() {
                    if (storingFilterDataCheckbox.is(':checked')) {
                        var savedValue = localStorage.getItem(current_route_name + element);
                        if (savedValue) {
                            if (element === '#role') {
                                // Handle Select2 specifically
                                var parsedValue = savedValue.split(',').filter(v => v);
                                $(element).val(parsedValue).trigger('change');
                            } else {
                                $(element).val(savedValue).trigger('change');
                            }
                        }
                    }
                }, 100);
                
                // Save and apply filters on change
                $(element).change(function(e) {
                    if (storingFilterDataCheckbox.is(':checked')) {
                        var value = $(element).val();
                        if (element === '#role' && Array.isArray(value)) {
                            // Handle Select2 array values
                            localStorage.setItem(current_route_name + element, value.join(','));
                        } else {
                            localStorage.setItem(current_route_name + element, value);
                        }
                    }
                    userTable.draw();
                    e.preventDefault();
                });
            });
            
            // Search input with debounce
            let searchTimeout;
            $('#search_text').keyup(function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    userTable.draw();
                }, 500);
            });
            
            // Clear all filters
            function clearAllFilter() {
                filterElements.forEach(function(element) {
                    $(element).val(null).trigger('change');
                    localStorage.removeItem(current_route_name + element);
                });
                $('#role').val(null).trigger('change'); // Clear Select2
                $('#search_text').val('');
                $('#user_creation_date_range').val('');
                userTable.draw();
            }
            $('#clear_all_filter_button').on('click', clearAllFilter);
            
            // Filter area toggle
            $('#filter_area_controller').on('click', function() {
                var $filter_area = $('#filter_area');
                var isVisible = $filter_area.is(':visible');
                
                if (isVisible) {
                    $filter_area.hide();
                    localStorage.setItem('user_filter_area_visibility', 'hidden');
                } else {
                    $filter_area.show();
                    localStorage.setItem('user_filter_area_visibility', 'show');
                }
            });
            
            // Restore filter area visibility
            if (localStorage.getItem('user_filter_area_visibility') === 'hidden') {
                $('#filter_area').hide();
            }
            
            // Update custom datatable info
            function updateDataTableInfo() {
                $('#datatable-info-custom').text($('.dataTables_info').text());
            }
            
            userTable.on('draw', function() {
                updateDataTableInfo();
                updateTextForNumberOfSelectedRows();
            });
            
            updateDataTableInfo();
            
            // Move export buttons and ensure functionality
            @if(auth()->user()->hasAnyRole(['developer', 'admin']))
                userTable.on('buttons-action', function(e, buttonApi, dataTable, node, config) {
                    // This ensures buttons work properly after moving
                });
                
                setTimeout(function() {
                    // Move the buttons to the container above table
                    const exportButtons = $('.dt-buttons');
                    if (exportButtons.length) {
                        // Move (not clone) the original buttons to maintain functionality
                        exportButtons.detach().appendTo('#export-buttons-container');
                        
                        // Apply proper styling to the buttons
                        $('.dt-button').each(function() {
                            const $btn = $(this);
                            // Remove any conflicting classes and styles
                            $btn.removeClass('buttons-csv buttons-excel buttons-pdf buttons-html5');
                            $btn.removeAttr('style');
                            
                            // Add our custom classes
                            $btn.addClass('inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors');
                        });
                        
                        // Show the export buttons section
                        $('#export-buttons-section').show();
                    }
                }, 100);
            @endif
        });
    </script>
    @endpush
    
    @push('styles')
    <style>
        table.dataTable tbody tr.selected {
            background-color: #dbeafe !important;
        }
        
        .dark table.dataTable tbody tr.selected {
            background-color: #1e3a8a !important;
        }
        
        .flatpickr-clear {
            background: #dc2626;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
            text-align: center;
            margin-top: 5px;
            border-radius: 3px;
        }
        
        .flatpickr-clear:hover {
            background: #b91c1c;
        }
        
        /* DataTables Tailwind Integration */
        .dataTables_wrapper {
            @apply text-gray-700 dark:text-gray-300;
        }
        
        /* Export Buttons Styling */
        .dt-buttons {
            @apply flex flex-wrap gap-2;
        }
        
        #export-buttons-container .dt-buttons {
            @apply flex flex-wrap gap-2;
        }
        
        .dt-button,
        #export-buttons-container .dt-button {
            @apply inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors !important;
            margin: 0 !important;
            text-decoration: none !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }
        
        .dt-button:hover,
        #export-buttons-container .dt-button:hover {
            @apply bg-gray-50 dark:bg-gray-600 border-gray-400 dark:border-gray-500 !important;
            color: inherit !important;
            transform: translateY(0) !important;
        }
        
        .dt-button:focus,
        #export-buttons-container .dt-button:focus {
            @apply ring-2 ring-offset-2 ring-blue-500 !important;
        }
        
        .dt-button span,
        #export-buttons-container .dt-button span {
            @apply flex items-center;
        }
        
        /* Remove any default DataTables button styling */
        .dt-button.buttons-csv,
        .dt-button.buttons-excel, 
        .dt-button.buttons-pdf,
        .dt-button.buttons-html5 {
            background: inherit !important;
            border: inherit !important;
            color: inherit !important;
        }
        
        /* Length and Filter Controls */
        .dataTables_length {
            @apply mb-0 flex-shrink-0;
        }
        
        .dataTables_length label {
            @apply flex items-center text-sm font-medium text-gray-700 dark:text-gray-300;
        }
        
        .dataTables_length select {
            @apply mx-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500;
        }
        
        .dataTables_filter {
            @apply mb-0 flex-shrink-0;
        }
        
        .dataTables_filter label {
            @apply flex items-center text-sm font-medium text-gray-700 dark:text-gray-300;
        }
        
        .dataTables_filter input {
            @apply ml-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-500;
        }
        
        /* Ensure proper layout */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            float: none !important;
        }
        
        /* Info Text */
        .dataTables_info {
            @apply text-xs text-gray-600 dark:text-gray-400 mb-2;
        }
        
        /* Pagination */
        .dataTables_paginate {
            @apply flex justify-center items-center space-x-1 mt-3;
        }
        
        .dataTables_paginate .paginate_button {
            @apply inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 !important;
            text-decoration: none !important;
            margin: 0 2px !important;
            min-width: 2rem;
            text-align: center;
        }
        
        .dataTables_paginate .paginate_button:hover:not(.disabled) {
            @apply bg-gray-50 dark:bg-gray-700 border-gray-400 dark:border-gray-500 transform translate-y-0 !important;
        }
        
        .dataTables_paginate .paginate_button.current {
            @apply bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700 shadow-md !important;
        }
        
        .dataTables_paginate .paginate_button.disabled {
            @apply opacity-40 cursor-not-allowed bg-gray-100 dark:bg-gray-900 text-gray-400 dark:text-gray-600 border-gray-200 dark:border-gray-800 !important;
        }
        
        .dataTables_paginate .paginate_button.disabled:hover {
            @apply bg-gray-100 dark:bg-gray-900 border-gray-200 dark:border-gray-800 transform-none !important;
        }
        
        /* Special styling for Previous/Next buttons */
        .dataTables_paginate .paginate_button.previous,
        .dataTables_paginate .paginate_button.next {
            @apply px-4 font-medium;
        }
        
        .dataTables_paginate .paginate_button.previous::before {
            content: "← ";
        }
        
        .dataTables_paginate .paginate_button.next::after {
            content: " →";
        }
        
        /* DataTables Layout Adjustments */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            @apply text-gray-700 dark:text-gray-300;
        }
        
        /* Processing Indicator */
        .dataTables_processing {
            @apply bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md text-gray-900 dark:text-gray-100 !important;
        }
        
        /* Additional DataTables Control Styling */
        .dataTables_wrapper .row {
            @apply flex flex-wrap items-center justify-between;
        }
        
        .dataTables_wrapper .col-sm-12 {
            @apply w-full;
        }
        
        .dataTables_wrapper .col-sm-6 {
            @apply w-full lg:w-auto;
        }
        
        /* Ensure proper spacing and alignment */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            @apply mb-0;
        }
        
        .dataTables_wrapper .dataTables_info {
            @apply mt-2;
        }
        
        .dataTables_wrapper .dataTables_paginate {
            @apply mt-2;
        }
        
        /* Override default Bootstrap-like styling */
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label {
            font-weight: 500 !important;
            margin-bottom: 0 !important;
        }
        
        /* Button group spacing */
        .dt-buttons .dt-button {
            margin: 0 !important;
        }
        
        /* Remove default outline styles */
        .dataTables_wrapper .dataTables_paginate .paginate_button:focus,
        .dt-button:focus {
            outline: 2px solid #3b82f6 !important;
            outline-offset: 2px !important;
        }
        
        /* Override any remaining DataTables default styles */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: inherit !important;
            background: inherit !important;
            border: inherit !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            color: inherit !important;
            background: inherit !important;
            border: inherit !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: inherit !important;
            background: inherit !important;
            border: inherit !important;
        }
        
        /* Remove default DataTables pagination container styling */
        .dataTables_paginate {
            text-align: center !important;
        }
        
        .paginate_button {
            display: inline-block !important;
            padding: 0 !important;
            margin: 0 !important;
            border: 0 !important;
            background: transparent !important;
            color: inherit !important;
        }
        
        /* Table styling */
        #user-table_wrapper .dataTables_scrollHead,
        #user-table_wrapper .dataTables_scrollBody {
            @apply border-gray-200 dark:border-gray-700;
        }
        
        /* Select2 Dark Mode Styling */
        .select2-container--default .select2-selection--multiple {
            background-color: white !important;
            border-color: #d1d5db !important;
            color: #111827 !important;
        }
        
        .dark .select2-container--default .select2-selection--multiple {
            background-color: #1f2937 !important;
            border-color: #4b5563 !important;
            color: #f9fafb !important;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #dbeafe !important;
            color: #1e40af !important;
            border-color: #bfdbfe !important;
        }
        
        .dark .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #1e3a8a !important;
            color: #dbeafe !important;
            border-color: #1e40af !important;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #2563eb !important;
        }
        
        .dark .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #93c5fd !important;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #1d4ed8 !important;
        }
        
        .dark .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #dbeafe !important;
        }
        
        .select2-dropdown {
            background-color: white !important;
            border-color: #d1d5db !important;
            color: #111827 !important;
        }
        
        .dark .select2-dropdown {
            background-color: #1f2937 !important;
            border-color: #4b5563 !important;
            color: #f9fafb !important;
        }
        
        .select2-container--default .select2-results__option {
            color: #111827 !important;
        }
        
        .dark .select2-container--default .select2-results__option {
            color: #f9fafb !important;
        }
        
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #2563eb !important;
            color: white !important;
        }
        
        .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: white !important;
            border-color: #d1d5db !important;
            color: #111827 !important;
        }
        
        .dark .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: #1f2937 !important;
            border-color: #4b5563 !important;
            color: #f9fafb !important;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            color: #6b7280 !important;
        }
        
        .dark .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            color: #9ca3af !important;
        }
    </style>
    @endpush
</x-admin-dashboard-layout::layout>