<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Filter Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Activity Logs</h2>
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
                </div>
            </div>
            
            <div id="filter_area" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-3" style="display: block;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label for="log_name" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Log Type</label>
                        <select multiple class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="log_name[]" id="log_name">
                            @foreach ($logNames as $logName)
                                <option value="{{ $logName }}">{{ ucfirst($logName) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="subject_type" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Subject Type</label>
                        <select multiple class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="subject_type[]" id="subject_type">
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject }}">{{ class_basename($subject) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="activity_date_range" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Date Range</label>
                        <input class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" type="text" name="activity_date_range" id="activity_date_range" placeholder="Select date range">
                    </div>
                    <div>
                        <label for="search_text" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Quick Search</label>
                        <input class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" type="text" name="search_text" id="search_text" placeholder="Search by description...">
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
        <input type="hidden" id="starting_date">
        <input type="hidden" id="ending_date">
        
        <!-- DataTable Info -->
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
            <div id="datatable-info-custom" class="text-xs text-gray-600 dark:text-gray-400"></div>
        </div>
        
        <!-- DataTable Container -->
        <div class="overflow-hidden">
            <table id="activity-log-table" class="w-full divide-y divide-gray-200 dark:divide-gray-700">
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
        const current_route_name = 'admin-dashboard.activity-logs.index';
        
        $(document).ready(function() {
            // DataTable configuration
            var activityLogTable = $('#activity-log-table').DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 500,
                pageLength: 25,
                lengthMenu: [1, 10, 25, 50, 100, 200],
                scrollX: true,
                autoWidth: false,
                responsive: false,
                ajax: {
                    url: '{{ route('admin-dashboard.activity-logs.json') }}',
                    type: "POST",
                    data: function(d) {
                        d.log_name = $('#log_name').val();
                        d.subject_type = $('#subject_type').val();
                        d.starting_date = $('#starting_date').val();
                        d.ending_date = $('#ending_date').val();
                        d.search_text = $('#search_text').val();
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        title: 'ID',
                        searchable: true,
                        className: 'text-center w-20'
                    },
                    {
                        data: 'created_at_formatted',
                        name: 'created_at',
                        title: 'Date & Time',
                        searchable: false,
                        orderable: true,
                        className: 'w-32'
                    },
                    {
                        data: 'activity_type',
                        name: 'log_name',
                        title: 'Type',
                        searchable: false,
                        orderable: true,
                        className: 'text-center w-24'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        title: 'Activity',
                        searchable: true,
                        className: 'font-medium'
                    },
                    {
                        data: 'causer_info',
                        name: 'causer_id',
                        title: 'Performed By',
                        searchable: false,
                        orderable: false,
                        className: 'w-48'
                    },
                    {
                        data: 'subject_info',
                        name: 'subject_id',
                        title: 'Subject',
                        searchable: false,
                        orderable: false,
                        className: 'w-48'
                    },
                    {
                        data: 'changes_summary',
                        name: 'properties',
                        title: 'Changes',
                        searchable: false,
                        orderable: false,
                        className: 'w-64'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        title: 'Actions',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-24'
                    }
                ],
                order: [[1, 'desc']],
                language: {
                    search: "Search activities:",
                    lengthMenu: "Show _MENU_ activities per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ activities",
                    infoEmpty: "No activities found",
                    infoFiltered: "(filtered from _MAX_ total activities)",
                    processing: '<div class="flex items-center justify-center"><svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle><path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="ml-2">Loading...</span></div>'
                },
                dom: '<"flex flex-row justify-between items-center mb-2 gap-2"lf>rtip',
                drawCallback: function() {
                    // Apply Tailwind styles after draw
                    $('#activity-log-table').addClass('divide-y divide-gray-200 dark:divide-gray-700');
                    $('#activity-log-table thead').addClass('bg-gray-50 dark:bg-gray-700');
                    $('#activity-log-table thead th').addClass('px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider');
                    $('#activity-log-table tbody').addClass('bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700');
                    $('#activity-log-table tbody td').addClass('px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100');
                    
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
            
            // Initialize Select2 for filters
            $('#log_name, #subject_type').select2({
                placeholder: "Select options",
                allowClear: true,
                closeOnSelect: false,
                theme: 'default',
                width: '100%'
            });
            
            // Initialize date range picker
            $('#activity_date_range').flatpickr({
                mode: "range",
                dateFormat: "Y-m-d",
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        const startDate = flatpickr.formatDate(selectedDates[0], "Y-m-d");
                        const endDate = flatpickr.formatDate(selectedDates[1], "Y-m-d");
                        $('#starting_date').val(startDate);
                        $('#ending_date').val(endDate);
                        activityLogTable.draw();
                    }
                },
                onReady: function(dateObj, dateStr, instance) {
                    var $cal = $(instance.calendarContainer);
                    if ($cal.find('.flatpickr-clear').length < 1) {
                        $cal.append('<div class="flatpickr-clear">Clear</div>');
                        $cal.find('.flatpickr-clear').on('click', function() {
                            instance.clear();
                            instance.close();
                            $('#starting_date').val('');
                            $('#ending_date').val('');
                            activityLogTable.draw();
                        });
                    }
                }
            });
            
            // Page navigation
            dataTableNavigate(activityLogTable);
            
            // Filter change listeners
            var filterElements = [
                '#log_name',
                '#subject_type',
                '#starting_date',
                '#ending_date'
            ];
            
            // Local storage for filter persistence
            const storingFilterDataCheckbox = $('#storing_filter_data');
            const storing_filter_data_local_forage_key = 'storing_filter_data_activity_logs';
            
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
                            if (element === '#log_name' || element === '#subject_type') {
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
                        if ((element === '#log_name' || element === '#subject_type') && Array.isArray(value)) {
                            localStorage.setItem(current_route_name + element, value.join(','));
                        } else {
                            localStorage.setItem(current_route_name + element, value);
                        }
                    }
                    activityLogTable.draw();
                    e.preventDefault();
                });
            });
            
            // Search input with debounce
            let searchTimeout;
            $('#search_text').keyup(function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    activityLogTable.draw();
                }, 500);
            });
            
            // Clear all filters
            function clearAllFilter() {
                filterElements.forEach(function(element) {
                    $(element).val(null).trigger('change');
                    localStorage.removeItem(current_route_name + element);
                });
                $('#search_text').val('');
                $('#activity_date_range').val('');
                activityLogTable.draw();
            }
            $('#clear_all_filter_button').on('click', clearAllFilter);
            
            // Filter area toggle
            $('#filter_area_controller').on('click', function() {
                var $filter_area = $('#filter_area');
                var isVisible = $filter_area.is(':visible');
                
                if (isVisible) {
                    $filter_area.hide();
                    localStorage.setItem('activity_log_filter_area_visibility', 'hidden');
                } else {
                    $filter_area.show();
                    localStorage.setItem('activity_log_filter_area_visibility', 'show');
                }
            });
            
            // Restore filter area visibility
            if (localStorage.getItem('activity_log_filter_area_visibility') === 'hidden') {
                $('#filter_area').hide();
            }
            
            // Update custom datatable info
            function updateDataTableInfo() {
                $('#datatable-info-custom').text($('.dataTables_info').text());
            }
            
            activityLogTable.on('draw', function() {
                updateDataTableInfo();
            });
            
            updateDataTableInfo();
        });
    </script>
    @endpush
    
    @push('styles')
    <style>
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
        
        /* Pagination - Override DataTables Tailwind theme */
        .dataTables_paginate {
            @apply flex justify-center items-center space-x-1 mt-3 !important;
            width: 100% !important;
            text-align: center !important;
        }
        
        .dataTables_wrapper .dataTables_paginate {
            @apply flex justify-center items-center mt-4 !important;
            float: none !important;
            text-align: center !important;
            width: 100% !important;
        }
        
        /* Reset and style pagination buttons */
        .dataTables_paginate .paginate_button {
            /* Reset all styles first */
            all: unset !important;
            /* Apply our custom styling */
            @apply inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 !important;
            text-decoration: none !important;
            margin: 0 2px !important;
            min-width: 2rem !important;
            text-align: center !important;
            box-sizing: border-box !important;
            cursor: pointer !important;
            display: inline-flex !important;
            justify-content: center !important;
            align-items: center !important;
        }
        
        .dataTables_paginate .paginate_button:hover:not(.disabled) {
            @apply bg-gray-50 dark:bg-gray-700 border-gray-400 dark:border-gray-500 transform translate-y-0 !important;
            background-color: rgb(249 250 251) !important;
        }
        
        .dataTables_paginate .paginate_button.current {
            @apply bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700 shadow-md !important;
            background-color: rgb(37 99 235) !important;
            color: white !important;
            border-color: rgb(37 99 235) !important;
        }
        
        .dataTables_paginate .paginate_button.disabled {
            @apply opacity-40 cursor-not-allowed bg-gray-100 dark:bg-gray-900 text-gray-400 dark:text-gray-600 border-gray-200 dark:border-gray-800 !important;
            background-color: rgb(243 244 246) !important;
            color: rgb(156 163 175) !important;
        }
        
        .dataTables_paginate .paginate_button.disabled:hover {
            @apply bg-gray-100 dark:bg-gray-900 border-gray-200 dark:border-gray-800 transform-none !important;
            background-color: rgb(243 244 246) !important;
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
            @apply w-full md:w-1/2;
        }
        
        /* Table wrapper improvements */
        .dataTables_wrapper {
            @apply w-full;
        }
        
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            @apply mb-4;
        }
        
        .dataTables_wrapper .dataTables_info {
            @apply mt-2 mb-2;
        }
        
        .dataTables_wrapper .dataTables_paginate {
            @apply mt-2;
        }
    </style>
    @endpush
</x-admin-dashboard-layout::layout>