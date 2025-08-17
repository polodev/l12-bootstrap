<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Coupon Management</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage discount coupons and promotional codes</p>
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
                    <a href="{{ route('coupon::admin.coupons.create') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create New Coupon
                    </a>
                </div>
            </div>
            
            <div id="filter_area" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-3" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label for="status" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
                        <select class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="status" id="status">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>
                    <div>
                        <label for="type" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Coupon Type</label>
                        <select class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="type" id="type">
                            <option value="">All Types</option>
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed Amount</option>
                        </select>
                    </div>
                    <div>
                        <label for="search_text" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Quick Search</label>
                        <input class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" type="text" name="search_text" id="search_text" placeholder="Search by coupon code or name...">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- DataTable Info -->
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
            <div id="datatable-info-custom" class="text-xs text-gray-600 dark:text-gray-400"></div>
        </div>
        
        <!-- DataTable Container -->
        <div class="overflow-hidden">
            <table id="coupons-table" class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <!-- DataTables will handle thead and tbody -->
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // DataTable configuration
            var couponsTable = $('#coupons-table').DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 500,
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100],
                scrollX: true,
                scrollCollapse: true,
                autoWidth: false,
                responsive: false,
                ajax: {
                    url: '{{ route('coupon::admin.coupons.json') }}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.status = $('#status').val() || '';
                        d.type = $('#type').val() || '';
                        d.search_text = $('#search_text').val() || '';
                    }
                },
                columns: [
                    {
                        data: 'coupon_info',
                        name: 'code',
                        title: 'Coupon Information',
                        searchable: true,
                        className: 'min-w-48'
                    },
                    {
                        data: 'discount_info',
                        name: 'type',
                        title: 'Discount',
                        searchable: false,
                        className: 'min-w-32'
                    },
                    {
                        data: 'usage_info',
                        name: 'used_count',
                        title: 'Usage',
                        searchable: false,
                        orderable: true,
                        className: 'text-center w-24'
                    },
                    {
                        data: 'validity_info',
                        name: 'expires_at',
                        title: 'Validity',
                        searchable: false,
                        orderable: true,
                        className: 'min-w-32'
                    },
                    {
                        data: 'status_badge',
                        name: 'is_active',
                        title: 'Status',
                        searchable: false,
                        orderable: true,
                        className: 'text-center w-28'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        title: 'Actions',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-32'
                    }
                ],
                order: [[0, 'asc']],
                language: {
                    search: "Search coupons:",
                    lengthMenu: "Show _MENU_ items per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ items",
                    infoEmpty: "No coupons found",
                    infoFiltered: "(filtered from _MAX_ total items)",
                    processing: '<div class="flex items-center justify-center"><svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle><path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="ml-2">Loading...</span></div>'
                },
                dom: '<"flex flex-row justify-between items-center mb-2 gap-2"lf>rtip',
                drawCallback: function() {
                    // Apply Tailwind styles after draw
                    $('#coupons-table').addClass('divide-y divide-gray-200 dark:divide-gray-700');
                    $('#coupons-table thead').addClass('bg-gray-50 dark:bg-gray-700');
                    $('#coupons-table thead th').addClass('px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider');
                    $('#coupons-table tbody').addClass('bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700');
                    $('#coupons-table tbody td').addClass('px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100');
                    
                    // Fix column alignment after draw
                    setTimeout(function() {
                        couponsTable.columns.adjust();
                    }, 100);
                }
            });
            
            // Filter change listeners
            var filterElements = ['#status', '#type'];
            
            filterElements.forEach(function(element) {
                $(element).change(function(e) {
                    couponsTable.draw();
                    e.preventDefault();
                });
            });
            
            // Search input with debounce
            let searchTimeout;
            $('#search_text').keyup(function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    couponsTable.draw();
                }, 500);
            });
            
            // Clear all filters
            function clearAllFilter() {
                filterElements.forEach(function(element) {
                    $(element).val('').trigger('change');
                });
                $('#search_text').val('');
                couponsTable.draw();
            }
            $('#clear_all_filter_button').on('click', clearAllFilter);
            
            // Filter area toggle
            $('#filter_area_controller').on('click', function() {
                var $filter_area = $('#filter_area');
                $filter_area.toggle();
            });
            
            // Update custom datatable info
            function updateDataTableInfo() {
                $('#datatable-info-custom').text($('.dataTables_info').text());
            }
            
            couponsTable.on('draw', function() {
                updateDataTableInfo();
            });
            
            updateDataTableInfo();
        });
    </script>
    @endpush
    
    @push('styles')
    <style>
        /* DataTables Tailwind Integration */
        .dataTables_wrapper {
            @apply text-gray-700 dark:text-gray-300;
        }

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
        
        .dataTables_paginate .paginate_button.current {
            @apply bg-blue-600 text-white border-blue-600 hover:bg-blue-700 hover:border-blue-700 shadow-md !important;
        }
        
        .dataTables_paginate .paginate_button.disabled {
            @apply opacity-40 cursor-not-allowed bg-gray-100 dark:bg-gray-900 text-gray-400 dark:text-gray-600 border-gray-200 dark:border-gray-800 !important;
        }
    </style>
    @endpush
</x-admin-dashboard-layout::layout>