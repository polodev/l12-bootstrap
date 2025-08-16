<x-admin-dashboard-layout::layout>
    <x-slot name="title">My Files</x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">My Files</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Manage your uploaded files and media</p>
                </div>
                <a href="{{ route('my-file::create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Add New File
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-file text-2xl text-blue-500"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Files</dt>
                                    <dd class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ \Modules\MyFile\Models\MyFile::count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-2xl text-green-500"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Active Files</dt>
                                    <dd class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ \Modules\MyFile\Models\MyFile::active()->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-cloud text-2xl text-purple-500"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">With Media</dt>
                                    <dd class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ \Modules\MyFile\Models\MyFile::withFiles()->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-pause-circle text-2xl text-red-500"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Inactive Files</dt>
                                    <dd class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ \Modules\MyFile\Models\MyFile::where('is_active', false)->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DataTable -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="overflow-x-auto">
                        <table id="myFilesTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        #
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Preview
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        File Info
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Created
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#myFilesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("my-file::index_json") }}',
                    type: "POST"
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'file_preview', name: 'file_preview', orderable: false, searchable: false},
                    {data: 'title', name: 'title'},
                    {data: 'file_info', name: 'file_info', orderable: false, searchable: false},
                    {data: 'status', name: 'is_active'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                order: [[5, 'desc']],
                responsive: true,
                dom: '<"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4"<"flex items-center gap-2"l><"flex items-center gap-2"f>>rtip',
                language: {
                    search: '',
                    searchPlaceholder: 'Search files...',
                    lengthMenu: '_MENU_ per page',
                    info: 'Showing _START_ to _END_ of _TOTAL_ files',
                    infoEmpty: 'No files found',
                    infoFiltered: '(filtered from _MAX_ total files)',
                    emptyTable: 'No files available',
                    processing: '<div class="flex items-center justify-center"><i class="fas fa-spinner fa-spin mr-2"></i> Loading...</div>'
                },
                drawCallback: function() {
                    // Add Tailwind classes to pagination
                    $('.dataTables_paginate .paginate_button').addClass('px-3 py-2 text-sm leading-4 border rounded-md text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700');
                    $('.dataTables_paginate .paginate_button.current').addClass('bg-blue-500 text-white border-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700');
                    $('.dataTables_paginate .paginate_button.disabled').addClass('opacity-50 cursor-not-allowed');
                }
            });

            // Add URL navigation functionality
            dataTableNavigate(table);
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>