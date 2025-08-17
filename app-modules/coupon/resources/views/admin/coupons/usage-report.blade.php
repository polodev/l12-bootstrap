<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header Section -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Coupon Usage Report</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">View detailed usage statistics and performance metrics for all coupons</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('coupon::admin.coupons.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Coupons
                    </a>
                    <a href="{{ route('coupon::admin.coupons.create') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Coupon
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="p-6">
            <!-- DataTable -->
            <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                <table id="usage-report-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Coupon Details
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Usage Statistics
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Discount Impact
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- DataTable will populate this -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#usage-report-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                order: [[1, 'desc']], // Order by usage statistics (most used first)
                ajax: {
                    url: '{{ route("coupon::admin.coupons.usage-report.json") }}',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    {
                        data: 'coupon_info',
                        name: 'coupon_info',
                        orderable: false,
                        searchable: true,
                        width: '25%'
                    },
                    {
                        data: 'usage_stats',
                        name: 'usages_count',
                        searchable: false,
                        width: '20%'
                    },
                    {
                        data: 'discount_stats',
                        name: 'usages_sum_discount_amount',
                        searchable: false,
                        width: '20%'
                    },
                    {
                        data: 'status_badge',
                        name: 'is_active',
                        searchable: false,
                        width: '15%'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        width: '20%'
                    }
                ],
                language: {
                    processing: '<div class="flex items-center justify-center"><svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="ml-2">Loading...</span></div>',
                    emptyTable: "No coupon usage data available",
                    info: "Showing _START_ to _END_ of _TOTAL_ coupons",
                    infoEmpty: "Showing 0 to 0 of 0 coupons",
                    infoFiltered: "(filtered from _MAX_ total coupons)",
                    lengthMenu: "Show _MENU_ coupons per page",
                    search: "Search coupons:",
                    zeroRecords: "No matching coupons found",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4"<"flex items-center mb-2 sm:mb-0"l><"flex items-center"f>>rtip',
                drawCallback: function(settings) {
                    // Custom styling after table draw
                    $('.dataTables_length select').addClass('px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100');
                    $('.dataTables_filter input').addClass('px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100');
                },
                initComplete: function() {
                    // Custom styling after initialization
                    $('.dataTables_length select').addClass('px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100');
                    $('.dataTables_filter input').addClass('px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100');
                }
            });
        });

        // Toggle coupon status function
        function toggleCouponStatus(couponId) {
            if (confirm('Are you sure you want to toggle the status of this coupon?')) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/coupons/${couponId}/toggle-status`;
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Delete coupon function
        function deleteCoupon(couponId) {
            if (confirm('Are you sure you want to delete this coupon? This action cannot be undone.')) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/coupons/${couponId}`;
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);
                
                // Add method override for DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
    @endpush

    @push('styles')
    <style>
        /* Custom DataTables styling for dark mode */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: rgb(107 114 128);
        }

        .dark .dataTables_wrapper .dataTables_length,
        .dark .dataTables_wrapper .dataTables_filter,
        .dark .dataTables_wrapper .dataTables_info,
        .dark .dataTables_wrapper .dataTables_paginate {
            color: rgb(156 163 175);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: rgb(75 85 99) !important;
            background: rgb(249 250 251) !important;
            border: 1px solid rgb(229 231 235) !important;
            border-radius: 0.375rem;
            margin: 0 2px;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: rgb(156 163 175) !important;
            background: rgb(55 65 81) !important;
            border: 1px solid rgb(75 85 99) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: rgb(59 130 246) !important;
            background: rgb(239 246 255) !important;
            border: 1px solid rgb(59 130 246) !important;
        }

        .dark .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: rgb(147 197 253) !important;
            background: rgb(30 58 138) !important;
            border: 1px solid rgb(147 197 253) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: rgb(255 255 255) !important;
            background: rgb(59 130 246) !important;
            border: 1px solid rgb(59 130 246) !important;
        }

        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: rgb(255 255 255) !important;
            background: rgb(59 130 246) !important;
            border: 1px solid rgb(59 130 246) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            color: rgb(156 163 175) !important;
            background: rgb(243 244 246) !important;
            border: 1px solid rgb(229 231 235) !important;
            cursor: not-allowed !important;
        }

        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            color: rgb(107 114 128) !important;
            background: rgb(31 41 55) !important;
            border: 1px solid rgb(55 65 81) !important;
        }
    </style>
    @endpush
</x-admin-dashboard-layout::layout>