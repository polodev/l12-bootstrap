@php use App\Helpers\Helpers; @endphp
<x-admin-dashboard-layout::layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400">
                    <li>
                        <div>
                            <a href="{{ route('support-ticket::admin.tickets.index') }}" class="hover:text-gray-700 dark:hover:text-gray-300 font-medium">
                                Support Tickets
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-4 w-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z"/>
                            </svg>
                            <span class="font-medium text-gray-700 dark:text-gray-300">
                                Ticket #{{ $ticket->id }}
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('support-ticket::admin.tickets.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            Ticket #{{ $ticket->id }}: {{ $ticket->title }}
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Created {{ Helpers::getDateAndDiff($ticket->created_at, false, true, true) }} by {{ $ticket->user->name }}
                        </p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <form action="{{ route('support-ticket::admin.tickets.assign-to-me', $ticket) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                            Assign to Me
                        </button>
                    </form>
                    <a href="{{ route('support-ticket::admin.tickets.edit', $ticket) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm">
                        Edit Ticket
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Ticket Details Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Ticket Details</h3>
                                <div class="flex space-x-2">
                                    {!! $ticket->status_badge !!}
                                    {!! $ticket->priority_badge !!}
                                </div>
                            </div>
                            
                            {!! \App\Helpers\Helpers::renderMarkdownCompact($ticket->description) !!}

                            @if($ticket->category)
                            <div class="mt-4 flex items-center space-x-2">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Category:</span>
                                {!! $ticket->category_badge !!}
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Conversation -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Conversation ({{ $ticket->messages->count() }} messages)</h3>
                            
                            <div class="space-y-4" id="messages-container">
                                @foreach($ticket->messages as $message)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 {{ $message->isFromCustomer() ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800' : 'bg-gray-50 dark:bg-gray-700' }} {{ $message->is_internal ? 'border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20' : '' }}">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-500">
                                                    <span class="text-xs font-medium leading-none text-white">
                                                        {{ $message->author->name ? substr($message->author->name, 0, 1) : '?' }}
                                                    </span>
                                                </span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $message->author->name }}
                                                </div>
                                                <div class="flex items-center space-x-2 text-xs text-gray-500 dark:text-gray-400">
                                                    {!! $message->author_badge !!}
                                                    @if($message->is_internal)
                                                        {!! $message->type_badge !!}
                                                    @endif
                                                    <span>{{ Helpers::getDateAndDiff($message->created_at, false, true, true) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @if(!$message->isFromCustomer())
                                        <div class="flex space-x-1">
                                            <button onclick="toggleVisibility({{ $message->id }})" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" title="Toggle visibility">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="editMessage({{ $message->id }})" class="text-yellow-400 hover:text-yellow-600" title="Edit message">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button onclick="deleteMessage({{ $message->id }})" class="text-red-400 hover:text-red-600" title="Delete message">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                    <div id="message-content-{{ $message->id }}">
                                        {!! \App\Helpers\Helpers::renderMarkdownCompact($message->message) !!}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Reply Forms -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="border-b border-gray-200 dark:border-gray-700 -mx-6 px-6 pb-4 mb-6">
                                <nav class="flex space-x-8">
                                    <button id="publicReplyTab" class="reply-tab-btn active py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600 dark:text-blue-400" onclick="switchTab('public')">
                                        Public Reply
                                    </button>
                                    <button id="internalNoteTab" class="reply-tab-btn py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300" onclick="switchTab('internal')">
                                        Internal Note
                                    </button>
                                    <button id="quickReplyTab" class="reply-tab-btn py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300" onclick="switchTab('quick')">
                                        Quick Reply
                                    </button>
                                </nav>
                            </div>

                            <!-- Public Reply Form -->
                            <div id="publicReplyForm" class="reply-form">
                                <form action="{{ route('support-ticket::admin.tickets.messages.store', $ticket) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="is_internal" value="0">
                                    <div class="mb-4">
                                        <label for="public_message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Your Reply (Visible to Customer)</label>
                                        <textarea id="public_message" name="message" rows="4"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                placeholder="Type your reply to the customer..."></textarea>
                                    </div>
                                    <div class="flex space-x-3">
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                            Send Reply
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Internal Note Form -->
                            <div id="internalNoteForm" class="reply-form hidden">
                                <form action="{{ route('support-ticket::admin.tickets.messages.store', $ticket) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="is_internal" value="1">
                                    <div class="mb-4">
                                        <label for="internal_message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Internal Note (Staff Only)</label>
                                        <textarea id="internal_message" name="message" rows="4"
                                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                placeholder="Type your internal note for staff..."></textarea>
                                    </div>
                                    <div class="flex space-x-3">
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                            Add Internal Note
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Quick Reply Form -->
                            <div id="quickReplyForm" class="reply-form hidden">
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-lg p-6 border border-green-200 dark:border-green-800">
                                    <form action="{{ route('support-ticket::admin.tickets.messages.quick-reply', $ticket) }}" method="POST">
                                        @csrf
                                        <div class="mb-6">
                                            <label for="template" class="flex items-center text-sm font-semibold text-green-800 dark:text-green-200 mb-3">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                                Quick Reply Template
                                            </label>
                                            <select id="template" name="template" required onchange="updatePreview(this)"
                                                    class="block w-full rounded-lg border-green-300 dark:border-green-600 dark:bg-green-800/50 shadow-sm focus:border-green-500 focus:ring-green-500 text-green-900 dark:text-green-100">
                                                <option value="">Select a template...</option>
                                                <option value="resolved" data-message="Thank you for contacting us. We're pleased to inform you that your issue has been resolved. If you continue to experience any problems, please don't hesitate to reach out to us.">✅ Issue Resolved</option>
                                                <option value="more_info" data-message="Thank you for reaching out to us. To better assist you, we'll need some additional information. Could you please provide more details about the issue you're experiencing?">❓ Need More Information</option>
                                                <option value="investigating" data-message="Thank you for your patience. We're currently investigating your issue and will get back to you with an update as soon as possible. We appreciate your understanding.">🔍 We're Investigating</option>
                                                <option value="escalated" data-message="Your ticket has been escalated to our senior support team for specialized assistance. They will review your case and provide you with a comprehensive solution shortly.">⬆️ Escalated to Senior Team</option>
                                                <option value="working" data-message="We're actively working on resolving your issue. Our technical team is investigating and we'll keep you updated on our progress. Thank you for your patience.">⚙️ Working on It</option>
                                                <option value="followup" data-message="We wanted to follow up on your recent ticket to ensure everything is working properly for you. Please let us know if you need any further assistance.">📞 Follow Up</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Message Preview -->
                                        <div id="messagePreview" class="mb-6 hidden">
                                            <label class="block text-sm font-medium text-green-800 dark:text-green-200 mb-2">Message Preview:</label>
                                            <div class="bg-white dark:bg-green-800 rounded-md border border-green-200 dark:border-green-600 p-4">
                                                <div id="previewContent" class="text-sm text-gray-700 dark:text-green-100"></div>
                                            </div>
                                        </div>

                                        <div class="mb-6">
                                            <label class="flex items-center bg-yellow-50 dark:bg-yellow-900/20 p-3 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                                <input type="checkbox" name="is_internal" value="1" class="rounded border-yellow-300 text-yellow-600 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                                                <span class="ml-3 text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                                    🔒 Make this an internal note (staff only)
                                                </span>
                                            </label>
                                        </div>
                                        
                                        <div class="flex space-x-3">
                                            <button type="submit" class="flex items-center bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg text-sm font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                </svg>
                                                Send Quick Reply
                                            </button>
                                            <button type="button" onclick="resetForm()" class="flex items-center bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-3 rounded-lg text-sm font-medium transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                                Reset
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Customer Info -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Customer Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $ticket->user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        <a href="mailto:{{ $ticket->user->email }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            {{ $ticket->user->email }}
                                        </a>
                                    </dd>
                                </div>
                                @if($ticket->user->mobile)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mobile</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $ticket->user->mobile }}</dd>
                                </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Member Since</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $ticket->user->created_at->format('M Y') }}</dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Meta -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Ticket Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                    <dd class="mt-1">{!! $ticket->status_badge !!}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Priority</dt>
                                    <dd class="mt-1">{!! $ticket->priority_badge !!}</dd>
                                </div>
                                @if($ticket->category)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</dt>
                                    <dd class="mt-1">{!! $ticket->category_badge !!}</dd>
                                </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Assigned To</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        @if($ticket->assignedTo)
                                            {{ $ticket->assignedTo->name }}
                                        @else
                                            <span class="text-gray-400">Unassigned</span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ Helpers::getDateAndDiff($ticket->created_at, false, true, true) }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ Helpers::getDateAndDiff($ticket->updated_at, false, true, true) }}
                                    </dd>
                                </div>
                                @if($ticket->closed_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Closed</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        {{ Helpers::getDateAndDiff($ticket->closed_at, false, true, true) }}
                                    </dd>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Assignment -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <form action="{{ route('support-ticket::admin.tickets.assign-to-me', $ticket) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Assign to Me
                                    </button>
                                </form>
                                
                                @if($assignableUsers->count() > 0)
                                <form id="assignForm" action="{{ route('support-ticket::admin.tickets.update', $ticket) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="title" value="{{ $ticket->title }}">
                                    <input type="hidden" name="description" value="{{ $ticket->description }}">
                                    <input type="hidden" name="status" value="{{ $ticket->status }}">
                                    <input type="hidden" name="priority" value="{{ $ticket->priority }}">
                                    <input type="hidden" name="category" value="{{ $ticket->category }}">
                                    <select name="assigned_to" onchange="this.form.submit()" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Assign to...</option>
                                        @foreach($assignableUsers as $user)
                                            <option value="{{ $user->id }}" {{ $ticket->assigned_to == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde@2.18.0/dist/easymde.min.css">
    <style>
        .EasyMDEContainer .editor-toolbar {
            border-color: #d1d5db;
        }
        .dark .EasyMDEContainer .editor-toolbar {
            background-color: #374151;
            border-color: #4b5563;
        }
        .dark .EasyMDEContainer .editor-toolbar > * {
            color: #d1d5db;
        }
        .dark .EasyMDEContainer .CodeMirror {
            background-color: #374151;
            color: #f9fafb;
        }
        .dark .EasyMDEContainer .CodeMirror-cursor {
            border-color: #f9fafb;
        }
        .dark .EasyMDEContainer .CodeMirror-gutters {
            background-color: #1f2937;
            border-color: #4b5563;
        }
        .dark .EasyMDEContainer .CodeMirror-linenumber {
            color: #9ca3af;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/easymde@2.18.0/dist/easymde.min.js"></script>
    <script>
        function switchTab(tabName) {
            // Hide all forms
            document.querySelectorAll('.reply-form').forEach(form => {
                form.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.reply-tab-btn').forEach(btn => {
                btn.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                btn.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });
            
            // Show selected form and activate tab
            if (tabName === 'public') {
                document.getElementById('publicReplyForm').classList.remove('hidden');
                document.getElementById('publicReplyTab').classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                document.getElementById('publicReplyTab').classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            } else if (tabName === 'internal') {
                document.getElementById('internalNoteForm').classList.remove('hidden');
                document.getElementById('internalNoteTab').classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                document.getElementById('internalNoteTab').classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            } else if (tabName === 'quick') {
                document.getElementById('quickReplyForm').classList.remove('hidden');
                document.getElementById('quickReplyTab').classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                document.getElementById('quickReplyTab').classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            }
        }

        function toggleVisibility(messageId) {
            $.ajax({
                url: '{{ route('support-ticket::admin.tickets.messages.toggle-visibility', ['ticket' => $ticket->id, 'message' => '__MESSAGE_ID__']) }}'.replace('__MESSAGE_ID__', messageId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload(); // Reload to see updated visibility
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while toggling message visibility.');
                }
            });
        }

        function deleteMessage(messageId) {
            if (confirm('Are you sure you want to delete this message?')) {
                $.ajax({
                    url: '{{ route('support-ticket::admin.tickets.messages.destroy', ['ticket' => $ticket->id, 'message' => '__MESSAGE_ID__']) }}'.replace('__MESSAGE_ID__', messageId),
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload(); // Reload to see updated messages
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while deleting the message.');
                    }
                });
            }
        }

        function editMessage(messageId) {
            const messageDiv = document.getElementById('message-content-' + messageId);
            if (!messageDiv) {
                alert('Message not found');
                return;
            }

            const currentContent = messageDiv.textContent.trim();
            const newContent = prompt('Edit message:', currentContent);
            
            if (newContent === null) {
                return; // User cancelled
            }
            
            if (newContent.trim() === '') {
                alert('Message cannot be empty');
                return;
            }

            $.ajax({
                url: '{{ route('support-ticket::admin.tickets.messages.update', ['ticket' => $ticket->id, 'message' => '__MESSAGE_ID__']) }}'.replace('__MESSAGE_ID__', messageId),
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    message: newContent.trim()
                },
                success: function(response) {
                    if (response.success) {
                        location.reload(); // Reload to see updated messages
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while updating the message.');
                }
            });
        }



        // Initialize EasyMDE editors
        let publicEditor, internalEditor;
        
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize EasyMDE for Public Reply
            publicEditor = new EasyMDE({
                element: document.getElementById('public_message'),
                spellChecker: false,
                autofocus: false,
                placeholder: 'Type your reply to the customer...',
                renderingConfig: {
                    singleLineBreaks: false,
                    codeSyntaxHighlighting: true,
                },
                toolbar: [
                    'bold', 'italic', 'heading', '|',
                    'quote', 'unordered-list', 'ordered-list', '|',
                    'link', 'image', '|',
                    'preview', 'side-by-side', 'fullscreen', '|',
                    'guide'
                ],
                status: ['autosave', 'lines', 'words', 'cursor']
            });

            // Initialize EasyMDE for Internal Note
            internalEditor = new EasyMDE({
                element: document.getElementById('internal_message'),
                spellChecker: false,
                autofocus: false,
                placeholder: 'Type your internal note for staff...',
                renderingConfig: {
                    singleLineBreaks: false,
                    codeSyntaxHighlighting: true,
                },
                toolbar: [
                    'bold', 'italic', 'heading', '|',
                    'quote', 'unordered-list', 'ordered-list', '|',
                    'link', 'image', '|',
                    'preview', 'side-by-side', 'fullscreen', '|',
                    'guide'
                ],
                status: ['autosave', 'lines', 'words', 'cursor']
            });

        });


        // Quick Reply functions
        function updatePreview(select) {
            const preview = document.getElementById('messagePreview');
            const content = document.getElementById('previewContent');
            const selectedOption = select.options[select.selectedIndex];
            
            if (selectedOption.value && selectedOption.dataset.message) {
                content.textContent = selectedOption.dataset.message;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }

        function resetForm() {
            document.getElementById('template').value = '';
            document.getElementById('messagePreview').classList.add('hidden');
            document.querySelector('input[name="is_internal"]').checked = false;
        }

        // Add form validation for EasyMDE editors
        document.getElementById('publicReplyForm').querySelector('form').addEventListener('submit', function(e) {
            if (publicEditor) {
                // Sync EasyMDE content before validation
                publicEditor.codemirror.save();
                
                // Check if content is empty
                const content = publicEditor.value().trim();
                if (!content) {
                    e.preventDefault();
                    alert('Please enter a message before sending.');
                    publicEditor.codemirror.focus();
                    return false;
                }
            }
        });

        document.getElementById('internalNoteForm').querySelector('form').addEventListener('submit', function(e) {
            if (internalEditor) {
                // Sync EasyMDE content before validation
                internalEditor.codemirror.save();
                
                // Check if content is empty
                const content = internalEditor.value().trim();
                if (!content) {
                    e.preventDefault();
                    alert('Please enter a message before sending.');
                    internalEditor.codemirror.focus();
                    return false;
                }
            }
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>