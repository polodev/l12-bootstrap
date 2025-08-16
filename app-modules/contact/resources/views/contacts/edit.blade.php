<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Contact</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update contact status and administrative notes</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('contact::admin.contacts.show', $contact) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Details
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Form -->
        <div class="p-6">
            <form action="{{ route('contact::admin.contacts.update', $contact) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column - Contact Information (Read-only) -->
                    <div class="space-y-6">
                        <!-- Contact Details -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Contact Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $contact->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $contact->email }}</p>
                                </div>
                                @if($contact->mobile)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mobile</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $contact->mobile }}</p>
                                </div>
                                @endif
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
                        
                        <!-- Message Details -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Message Details</h3>
                            <div class="space-y-3">
                                @if($contact->topic)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Topic/Subject</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $contact->topic }}</p>
                                </div>
                                @endif
                                @if($contact->department)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                                    <div class="mt-1">{!! $contact->department_badge !!}</div>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                                    <div class="mt-1 p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-md max-h-32 overflow-y-auto">
                                        <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $contact->message }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column - Editable Fields -->
                    <div class="space-y-6">
                        <!-- Reply Status -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Status Management</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reply Status</label>
                                    <div class="space-y-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="has_reply" value="0" {{ !$contact->has_reply ? 'checked' : '' }} class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Pending Reply</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="has_reply" value="1" {{ $contact->has_reply ? 'checked' : '' }} class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Replied</span>
                                        </label>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Mark whether this contact has been replied to</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Status</label>
                                    <div class="mt-1">{!! $contact->reply_status_badge !!}</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Administrative Remarks -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Administrative Notes</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Internal Remarks</label>
                                    <textarea name="remarks" id="remarks" rows="5" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-500" placeholder="Add internal notes, follow-up actions, or any administrative remarks...">{{ old('remarks', $contact->remarks) }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">These remarks are for internal use only and will not be visible to the contact submitter</p>
                                    @error('remarks')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Meta Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Contact Metadata</h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-700 dark:text-gray-300">Contact ID:</span>
                                    <span class="text-gray-900 dark:text-gray-100 font-mono">#{{ $contact->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700 dark:text-gray-300">Submitted:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ $contact->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700 dark:text-gray-300">Last Updated:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ $contact->updated_at->format('M d, Y H:i') }}</span>
                                </div>
                                @if($contact->page)
                                <div class="flex justify-between">
                                    <span class="text-gray-700 dark:text-gray-300">Source Page:</span>
                                    <span class="text-blue-600 dark:text-blue-400 font-mono text-xs">{{ $contact->page }}</span>
                                </div>
                                @endif
                                @if($contact->user)
                                <div class="flex justify-between">
                                    <span class="text-gray-700 dark:text-gray-300">Linked User:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ $contact->user->name }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Contact
                            </button>
                            <a href="{{ route('contact::admin.contacts.show', $contact) }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-dashboard-layout::layout>