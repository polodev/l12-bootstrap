<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Contact Details</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Contact ID: #{{ $contact->id }}</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('contact::admin.contacts.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                    <a href="{{ route('contact::admin.contacts.edit', $contact) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Contact
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Contact Details -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column - Contact Information -->
                <div class="space-y-6">
                    <!-- Personal Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Contact Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $contact->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    <a href="mailto:{{ $contact->email }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $contact->email }}</a>
                                </p>
                            </div>
                            @if($contact->mobile)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mobile</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    <a href="tel:{{ $contact->mobile }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $contact->mobile }}</a>
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Organization Information -->
                    @if($contact->organization || $contact->designation)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Organization</h3>
                        <div class="space-y-3">
                            @if($contact->organization)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Organization</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $contact->organization }}</p>
                            </div>
                            @endif
                            @if($contact->designation)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Designation</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $contact->designation }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Status & Meta Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Status & Tracking</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reply Status</label>
                                <div class="mt-1">{!! $contact->reply_status_badge !!}</div>
                            </div>
                            @if($contact->department)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                                <div class="mt-1">{!! $contact->department_badge !!}</div>
                            </div>
                            @endif
                            @if($contact->page)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Source Page</label>
                                <p class="mt-1 text-sm text-blue-600 dark:text-blue-400 font-mono">{{ $contact->page }}</p>
                            </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Submitted On</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $contact->created_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                            @if($contact->user)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Linked User</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $contact->user->name }} ({{ $contact->user->email }})</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Message & Administrative -->
                <div class="space-y-6">
                    <!-- Topic & Message -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Message Details</h3>
                        <div class="space-y-3">
                            @if($contact->topic)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Topic/Subject</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $contact->topic }}</p>
                            </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                                <div class="mt-1 p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-md">
                                    <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $contact->message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Admin Remarks -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Administrative Notes</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Remarks</label>
                                @if($contact->remarks)
                                    <div class="mt-1 p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-md">
                                        <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $contact->remarks }}</p>
                                    </div>
                                @else
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 italic">No remarks added yet.</p>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $contact->updated_at->format('F d, Y \a\t g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Quick Actions</h3>
                        <div class="space-y-2">
                            @if(!$contact->has_reply)
                                <form action="{{ route('contact::admin.contacts.update', $contact) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="has_reply" value="1">
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Mark as Replied
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('contact::admin.contacts.update', $contact) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="has_reply" value="0">
                                    <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Mark as Pending
                                    </button>
                                </form>
                            @endif
                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->topic ?? 'Your inquiry' }}" class="w-full inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Reply via Email
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-dashboard-layout::layout>