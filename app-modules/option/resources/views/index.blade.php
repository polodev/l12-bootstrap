<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Filter Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Options Management</h2>
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
                    <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700" onclick="openCreateModal()">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Option
                    </button>
                </div>
            </div>
            
            <div id="filter_area" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-3" style="display: block;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                    <div>
                        <label for="option_type" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Type</label>
                        <select multiple class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="option_type[]" id="option_type">
                            @foreach ($types as $type)
                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="batch_name" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Filter by Batch</label>
                        <select class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="batch_name" id="batch_name">
                            <option value="">All Batches</option>
                            @foreach ($batchNames as $batchName)
                                <option value="{{ $batchName }}">{{ $batchName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="is_autoload" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Autoload Status</label>
                        <select class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="is_autoload" id="is_autoload">
                            <option value="">All Options</option>
                            <option value="1">Autoload</option>
                            <option value="0">Manual</option>
                        </select>
                    </div>
                    <div>
                        <label for="is_system" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">System Status</label>
                        <select class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" name="is_system" id="is_system">
                            <option value="">All Options</option>
                            <option value="0">User Options</option>
                            <option value="1">System Options</option>
                        </select>
                    </div>
                    <div>
                        <label for="search_text" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Quick Search</label>
                        <input class="w-full px-2 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" type="text" name="search_text" id="search_text" placeholder="Search by name, description...">
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
        <input type="hidden" id="starting_date_of_option_create_at">
        <input type="hidden" id="ending_date_of_option_created_at">
        
        <!-- DataTable Info -->
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
            <div id="datatable-info-custom" class="text-xs text-gray-600 dark:text-gray-400"></div>
        </div>
        
        <!-- Multi-select Actions -->
        <div id="multi-select-actions" class="px-4 py-2 bg-blue-50 dark:bg-blue-900 border-b border-blue-200 dark:border-blue-700" style="display: none;">
            <div class="flex justify-between items-center">
                <span class="text-blue-800 dark:text-blue-200 text-xs">
                    <strong><span id="number_of_row_selected_text">0</span></strong> options selected
                </span>
                <div class="flex space-x-1">
                    <button type="button" class="px-2 py-1 text-xs text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-600" id="remove_selection_button">
                        Clear Selection
                    </button>
                    <button type="button" class="px-2 py-1 text-xs text-white bg-blue-600 border border-transparent rounded hover:bg-blue-700" id="all_selection_button">
                        Select All
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
            <table id="option-table" class="w-full divide-y divide-gray-200 dark:divide-gray-700">
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

    <!-- Create Option Modal -->
    <livewire:option--create-option-modal />

    @push('scripts')
    <script>
        const current_route_name = 'option::admin.options.index';
        
        $(document).ready(function() {
            // DataTable configuration
            var optionTable = $('#option-table').DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 500,
                pageLength: 25,
                lengthMenu: [10, 25, 50, 100, 200],
                scrollX: true,
                scrollCollapse: true,
                autoWidth: false,
                responsive: false,
                ajax: {
                    url: '{{ route('option::admin.options.json') }}',
                    type: "POST",
                    data: function(d) {
                        d.option_type = $('#option_type').val();
                        d.batch_name = $('#batch_name').val();
                        d.is_autoload = $('#is_autoload').val();
                        d.is_system = $('#is_system').val();
                        d.starting_date_of_option_create_at = $('#starting_date_of_option_create_at').val();
                        d.ending_date_of_option_created_at = $('#ending_date_of_option_created_at').val();
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
                        data: 'option_name',
                        name: 'option_name',
                        title: 'Option Name',
                        searchable: true,
                        className: 'font-medium'
                    },
                    {
                        data: 'batch_name',
                        name: 'batch_name',
                        title: 'Batch',
                        searchable: true,
                        orderable: false,
                        className: 'text-center w-28'
                    },
                    {
                        data: 'position',
                        name: 'position',
                        title: 'Position',
                        searchable: false,
                        orderable: true,
                        className: 'text-center w-20'
                    },
                    {
                        data: 'formatted_value',
                        name: 'option_value',
                        title: 'Value',
                        searchable: true,
                        orderable: false,
                        className: 'text-sm max-w-xs'
                    },
                    {
                        data: 'type_badge',
                        name: 'option_type',
                        title: 'Type',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-24'
                    },
                    {
                        data: 'autoload_badge',
                        name: 'is_autoload',
                        title: 'Autoload',
                        searchable: false,
                        orderable: false,
                        className: 'text-center w-24'
                    },
                    {
                        data: 'system_badge',
                        name: 'is_system',
                        title: 'System',
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
                        className: 'text-center w-32'
                    }
                ],
                order: [[7, 'desc']],
                language: {
                    search: "Search options:",
                    lengthMenu: "Show _MENU_ options per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ options",
                    infoEmpty: "No options found",
                    infoFiltered: "(filtered from _MAX_ total options)",
                    processing: '<div class="flex items-center justify-center"><svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle><path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="ml-2">Loading...</span></div>'
                },
                @if(auth()->user()->hasAnyRole(['developer', 'admin']))
                    buttons: [
                        {
                            extend: 'csv',
                            className: 'dt-button',
                            text: '<i class="fas fa-file-csv mr-1"></i> CSV',
                            title: 'Options Export'
                        },
                        {
                            extend: 'excel',
                            className: 'dt-button',
                            text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                            title: 'Options Export'
                        },
                        {
                            extend: 'pdf',
                            className: 'dt-button',
                            text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                            title: 'Options Export',
                            orientation: 'landscape'
                        }
                    ],
                    dom: 'B<"flex flex-row justify-between items-center mb-2 gap-2"lf>rtip',
                @else
                    dom: '<"flex flex-row justify-between items-center mb-2 gap-2"lf>rtip',
                @endif
                drawCallback: function() {
                    // Apply Tailwind styles after draw
                    $('#option-table').addClass('divide-y divide-gray-200 dark:divide-gray-700');
                    $('#option-table thead').addClass('bg-gray-50 dark:bg-gray-700');
                    $('#option-table thead th').addClass('px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider');
                    $('#option-table tbody').addClass('bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700');
                    $('#option-table tbody td').addClass('px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100');
                    
                    // Fix column alignment after draw
                    setTimeout(function() {
                        optionTable.columns.adjust();
                    }, 100);
                    
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
            $('#option-table tbody').on('click', 'tr', function() {
                $(this).toggleClass('selected bg-blue-100 dark:bg-blue-800');
                updateTextForNumberOfSelectedRows();
            });
            
            $('#remove_selection_button').on('click', function() {
                $('#option-table tbody tr').removeClass('selected bg-blue-100 dark:bg-blue-800');
                updateTextForNumberOfSelectedRows();
            });
            
            $('#all_selection_button').on('click', function() {
                $('#option-table tbody tr').addClass('selected bg-blue-100 dark:bg-blue-800');
                updateTextForNumberOfSelectedRows();
            });
            
            function updateTextForNumberOfSelectedRows() {
                var selectedCount = $('#option-table tbody tr.selected').length;
                $('#number_of_row_selected_text').text(selectedCount);
                
                if (selectedCount > 0) {
                    $('#multi-select-actions').show();
                } else {
                    $('#multi-select-actions').hide();
                }
            }
            
            // Initialize Select2 for type filter
            $('#option_type').select2({
                placeholder: "Select types to filter",
                allowClear: true,
                closeOnSelect: false,
                theme: 'default',
                width: '100%'
            });
            
            // Page navigation
            dataTableNavigate(optionTable);
            
            // Filter change listeners
            var filterElements = [
                '#option_type',
                '#batch_name',
                '#is_autoload',
                '#is_system',
                '#starting_date_of_option_create_at',
                '#ending_date_of_option_created_at'
            ];
            
            // Local storage for filter persistence
            const storingFilterDataCheckbox = $('#storing_filter_data');
            const storing_filter_data_local_forage_key = 'storing_filter_data_options';
            
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
                            if (element === '#option_type') {
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
                        if (element === '#option_type' && Array.isArray(value)) {
                            // Handle Select2 array values
                            localStorage.setItem(current_route_name + element, value.join(','));
                        } else {
                            localStorage.setItem(current_route_name + element, value);
                        }
                    }
                    optionTable.draw();
                    e.preventDefault();
                });
            });
            
            // Search input with debounce
            let searchTimeout;
            $('#search_text').keyup(function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    optionTable.draw();
                }, 500);
            });
            
            // Clear all filters
            function clearAllFilter() {
                filterElements.forEach(function(element) {
                    $(element).val(null).trigger('change');
                    localStorage.removeItem(current_route_name + element);
                });
                $('#option_type').val(null).trigger('change');
                $('#batch_name').val(null).trigger('change');
                $('#search_text').val('');
                optionTable.draw();
            }
            $('#clear_all_filter_button').on('click', clearAllFilter);
            
            // Filter area toggle
            $('#filter_area_controller').on('click', function() {
                var $filter_area = $('#filter_area');
                var isVisible = $filter_area.is(':visible');
                
                if (isVisible) {
                    $filter_area.hide();
                    localStorage.setItem('option_filter_area_visibility', 'hidden');
                } else {
                    $filter_area.show();
                    localStorage.setItem('option_filter_area_visibility', 'show');
                }
            });
            
            // Restore filter area visibility
            if (localStorage.getItem('option_filter_area_visibility') === 'hidden') {
                $('#filter_area').hide();
            }
            
            // Update custom datatable info
            function updateDataTableInfo() {
                $('#datatable-info-custom').text($('.dataTables_info').text());
            }
            
            optionTable.on('draw', function() {
                updateDataTableInfo();
                updateTextForNumberOfSelectedRows();
            });
            
            updateDataTableInfo();
            
            // Handle window resize to maintain column alignment
            $(window).on('resize', function() {
                optionTable.columns.adjust();
            });
            
            // Move export buttons and ensure functionality
            @if(auth()->user()->hasAnyRole(['developer', 'admin']))
                optionTable.on('buttons-action', function(e, buttonApi, dataTable, node, config) {
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

        // Modal functions
        function openCreateModal() {
            Livewire.dispatch('open-create-modal');
        }

        // Delete option function
        function deleteOption(optionId, optionName) {
            if (confirm(`Are you sure you want to delete the option "${optionName}"?`)) {
                fetch(`{{ url('dashboard/options') }}/${optionId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#option-table').DataTable().ajax.reload();
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the option.');
                });
            }
        }

        // Listen for option created event
        document.addEventListener('optionCreated', function() {
            $('#option-table').DataTable().ajax.reload();
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
        
        /* DataTables Tailwind Integration */
        .dataTables_wrapper {
            @apply text-gray-700 dark:text-gray-300;
        }

        /* Fix horizontal scroll header alignment */
        .dataTables_scrollHead {
            overflow: hidden !important;
        }
        
        .dataTables_scrollHeadInner {
            box-sizing: content-box !important;
            width: 100% !important;
        }
        
        .dataTables_scrollHeadInner table {
            margin-bottom: 0 !important;
            border-bottom: none !important;
        }
        
        .dataTables_scrollBody {
            border-top: 1px solid #e5e7eb !important;
        }
        
        .dark .dataTables_scrollBody {
            border-top-color: #374151 !important;
        }

        /* Ensure table layout is consistent */
        #option-table {
            table-layout: fixed !important;
            width: 100% !important;
        }
        
        /* Fixed column widths to prevent misalignment */
        #option-table th:nth-child(1),
        #option-table td:nth-child(1) {
            width: 80px !important;
            min-width: 80px !important;
        }
        
        #option-table th:nth-child(2),
        #option-table td:nth-child(2) {
            width: 200px !important;
            min-width: 200px !important;
        }
        
        #option-table th:nth-child(3),
        #option-table td:nth-child(3) {
            width: 120px !important;
            min-width: 120px !important;
        }
        
        #option-table th:nth-child(4),
        #option-table td:nth-child(4) {
            width: 80px !important;
            min-width: 80px !important;
        }
        
        #option-table th:nth-child(5),
        #option-table td:nth-child(5) {
            width: 300px !important;
            min-width: 300px !important;
        }
        
        #option-table th:nth-child(6),
        #option-table td:nth-child(6) {
            width: 100px !important;
            min-width: 100px !important;
        }
        
        #option-table th:nth-child(7),
        #option-table td:nth-child(7) {
            width: 100px !important;
            min-width: 100px !important;
        }
        
        #option-table th:nth-child(8),
        #option-table td:nth-child(8) {
            width: 100px !important;
            min-width: 100px !important;
        }
        
        #option-table th:nth-child(9),
        #option-table td:nth-child(9) {
            width: 150px !important;
            min-width: 150px !important;
        }
        
        #option-table th:nth-child(10),
        #option-table td:nth-child(10) {
            width: 150px !important;
            min-width: 150px !important;
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
    </style>
    @endpush
</x-admin-dashboard-layout::layout>