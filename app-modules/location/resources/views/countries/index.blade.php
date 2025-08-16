<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Filter Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Country Management</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Manage countries for travel destinations</p>
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
                    <a href="{{ route('location::admin.countries.create') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Country
                    </a>
                </div>
            </div>
            
            <div id="filter_area" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-3" style="display: block;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <div>
                        <label for="is_active" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Status</label>
                        <select class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="is_active" id="is_active">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label for="search_text" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Quick Search</label>
                        <input class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" type="text" name="search_text" id="search_text" placeholder="Search by name, code...">
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
            <table id="countries-table" class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <!-- DataTables will handle thead and tbody -->
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        const current_route_name = 'location::admin.countries.index';
        
        $(document).ready(function() {
            // DataTable configuration
            var countriesTable = $('#countries-table').DataTable({
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
                    url: '{{ route('location::admin.countries.json') }}',
                    type: "POST",
                    data: function(d) {
                        d.is_active = $('#is_active').val();
                        d.search_text = $('#search_text').val();
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        title: 'ID',
                        searchable: true,
                        className: 'text-center w-16'
                    },
                    {
                        data: 'name_formatted',
                        name: 'name',
                        title: 'Country Name',
                        searchable: true,
                        className: 'font-medium min-w-48'
                    },
                    {
                        data: 'code_formatted',
                        name: 'code',
                        title: 'Code',
                        searchable: true,
                        className: 'font-mono text-sm text-center w-24'
                    },
                    {
                        data: 'phone_code_formatted',
                        name: 'phone_code',
                        title: 'Phone Code',
                        searchable: true,
                        className: 'text-center w-24'
                    },
                    {
                        data: 'currency_formatted',
                        name: 'currency',
                        title: 'Currency',
                        searchable: true,
                        className: 'text-center w-24'
                    },
                    {
                        data: 'cities_count',
                        name: 'cities_count',
                        title: 'Cities',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-20'
                    },
                    {
                        data: 'status_badge',
                        name: 'is_active',
                        title: 'Status',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-24'
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
                        data: 'action',
                        name: 'action',
                        title: 'Actions',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-24'
                    }
                ],
                order: [[7, 'desc']],
                language: {
                    search: "Search by name, code:",
                    lengthMenu: "Show _MENU_ items per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ items",
                    infoEmpty: "No countries found",
                    infoFiltered: "(filtered from _MAX_ total items)",
                    processing: '<div class="flex items-center justify-center"><svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle><path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="ml-2">Loading...</span></div>'
                },
                dom: '<"flex flex-row justify-between items-center mb-2 gap-2"lf>rtip',
                drawCallback: function() {
                    // Apply Tailwind styles after draw
                    $('#countries-table').addClass('divide-y divide-gray-200 dark:divide-gray-700');
                    $('#countries-table thead').addClass('bg-gray-50 dark:bg-gray-700');
                    $('#countries-table thead th').addClass('px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider');
                    $('#countries-table tbody').addClass('bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700');
                    $('#countries-table tbody td').addClass('px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100');
                    
                    // Fix column alignment after draw
                    setTimeout(function() {
                        countriesTable.columns.adjust();
                    }, 100);
                }
            });
            
            // Filter change listeners
            var filterElements = ['#is_active'];
            
            filterElements.forEach(function(element) {
                $(element).change(function(e) {
                    countriesTable.draw();
                    e.preventDefault();
                });
            });
            
            // Search input with debounce
            let searchTimeout;
            $('#search_text').keyup(function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    countriesTable.draw();
                }, 500);
            });
            
            // Clear all filters
            function clearAllFilter() {
                filterElements.forEach(function(element) {
                    $(element).val('').trigger('change');
                });
                $('#search_text').val('');
                countriesTable.draw();
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
            
            countriesTable.on('draw', function() {
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