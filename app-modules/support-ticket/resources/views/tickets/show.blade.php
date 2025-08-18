<x-customer-account-layout::layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('support-ticket::tickets.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('messages.ticket') }} #{{ $ticket->id }}: {{ $ticket->title }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ __('messages.created_on') }} {{ $ticket->created_at->format('M d, Y H:i') }}
                    </p>
                </div>
            </div>
            <div class="flex space-x-3">
                @if($ticket->isClosed())
                <form action="{{ route('support-ticket::tickets.reopen', $ticket) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        {{ __('messages.reopen_ticket') }}
                    </button>
                </form>
                @else
                <form action="{{ route('support-ticket::tickets.close', $ticket) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.confirm_close_ticket', ['id' => $ticket->id]) }}')">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        {{ __('messages.close_ticket') }}
                    </button>
                </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Breadcrumbs -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400">
                    <li>
                        <div>
                            <a href="{{ route('support-ticket::tickets.index') }}" class="hover:text-gray-700 dark:hover:text-gray-300 font-medium">
                                {{ __('messages.support_tickets') }}
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-4 w-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z"/>
                            </svg>
                            <span class="font-medium text-gray-700 dark:text-gray-300">
                                {{ __('messages.ticket') }} #{{ $ticket->id }}
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>
            <!-- Ticket Status and Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-wrap gap-4 items-center justify-between mb-4">
                        <div class="flex flex-wrap gap-3">
                            {!! $ticket->status_badge !!}
                            {!! $ticket->priority_badge !!}
                            @if($ticket->category)
                                {!! $ticket->category_badge !!}
                            @endif
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('messages.last_updated') }}: {{ $ticket->updated_at->diffForHumans() }}
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">{{ __('messages.ticket_description') }}</h3>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            {!! \App\Helpers\Helpers::renderMarkdownCompact($ticket->description) !!}
                        </div>
                    </div>

                    @if($ticket->closed_at)
                    <div class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-800 dark:text-red-200">
                                    {{ __('messages.ticket_closed_on') }} {{ $ticket->closed_at->format('M d, Y H:i') }}
                                    ({{ $ticket->closed_at->diffForHumans() }})
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Conversation Thread -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('messages.conversation_history') }} ({{ $ticket->publicMessages->count() }} {{ __('messages.ticket_messages') }})
                    </h3>
                    
                    <div class="space-y-4" id="messages-container">
                        @forelse($ticket->publicMessages as $message)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 {{ $message->isFromCustomer() ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800' : 'bg-gray-50 dark:bg-gray-700' }}">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full {{ $message->isFromCustomer() ? 'bg-blue-500' : 'bg-gray-500' }}">
                                            <span class="text-xs font-medium leading-none text-white">
                                                {{ $message->author->name ? substr($message->author->name, 0, 1) : '?' }}
                                            </span>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $message->author->name }}
                                            @if($message->isFromCustomer())
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    {{ __('messages.you') }}
                                                </span>
                                            @else
                                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    {{ __('messages.support_team') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $message->created_at->format('M d, Y H:i') }}
                                            <span class="mx-1">•</span>
                                            {{ $message->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="message-content-{{ $message->id }}">
                                {!! \App\Helpers\Helpers::renderMarkdownCompact($message->message) !!}
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.no_messages_yet') }}</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('messages.start_conversation_below') }}</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Reply Form -->
            @if(!$ticket->isClosed())
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.add_reply') }}</h3>
                    
                    @if($errors->any())
                        <div class="mb-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">{{ __('messages.please_fix_errors') }}</h3>
                                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('support-ticket::tickets.messages.store', $ticket) }}" method="POST" id="replyForm">
                        @csrf
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.your_message') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea name="message" 
                                      id="message" 
                                      rows="5" 
                                      placeholder="{{ __('messages.type_your_reply') }}"
                                      class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ __('messages.reply_will_notify_support_team') }}
                            </p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                {{ __('messages.send_reply') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <!-- Closed Ticket Notice -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.884-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                            {{ __('messages.ticket_is_closed') }}
                        </h3>
                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                            <p>{{ __('messages.cannot_reply_closed_ticket') }}</p>
                            <p class="mt-1">{{ __('messages.reopen_to_continue_conversation') }}</p>
                        </div>
                        <div class="mt-4">
                            <form action="{{ route('support-ticket::tickets.reopen', $ticket) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                    {{ __('messages.reopen_ticket') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Help and Support Info -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.need_more_help') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.response_time') }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.we_respond_within_24_hours') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.business_hours') }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.mon_fri_9am_6pm') }}</p>
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
            @apply border-gray-300 dark:border-gray-600;
        }
        .dark .EasyMDEContainer .editor-toolbar {
            @apply bg-gray-700 border-gray-600;
        }
        .dark .EasyMDEContainer .editor-toolbar > * {
            @apply text-gray-300;
        }
        .dark .EasyMDEContainer .CodeMirror {
            @apply bg-gray-700 text-gray-100;
        }
        .dark .EasyMDEContainer .CodeMirror-cursor {
            @apply border-gray-100;
        }
        .dark .EasyMDEContainer .CodeMirror-gutters {
            @apply bg-gray-800 border-gray-600;
        }
        .dark .EasyMDEContainer .CodeMirror-linenumber {
            @apply text-gray-400;
        }
        
        /* Message content styling */
        .message-content {
            color: #374151;
            line-height: 1.625;
        }
        .dark .message-content {
            color: #d1d5db;
        }
        
        .message-content h1, .message-content h2, .message-content h3, .message-content h4, .message-content h5, .message-content h6 {
            font-weight: 600;
            color: #111827;
            margin-top: 1rem;
            margin-bottom: 0.75rem;
        }
        .dark .message-content h1, .dark .message-content h2, .dark .message-content h3, 
        .dark .message-content h4, .dark .message-content h5, .dark .message-content h6 {
            color: #f9fafb;
        }
        .message-content h1:first-child, .message-content h2:first-child, .message-content h3:first-child,
        .message-content h4:first-child, .message-content h5:first-child, .message-content h6:first-child {
            margin-top: 0;
        }
        
        .message-content h1 { font-size: 1.25rem; }
        .message-content h2 { font-size: 1.125rem; }
        .message-content h3 { font-size: 1rem; font-weight: 600; }
        .message-content h4, .message-content h5, .message-content h6 { font-size: 0.875rem; font-weight: 600; }
        
        .message-content p {
            margin-bottom: 1rem;
        }
        .message-content p:first-child {
            margin-top: 0;
        }
        .message-content p:last-child {
            margin-bottom: 0;
        }
        .message-content p:empty {
            margin-bottom: 0.5rem;
        }
        
        .message-content ul, .message-content ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }
        .message-content ul {
            list-style-type: disc;
        }
        .message-content ol {
            list-style-type: decimal;
        }
        .message-content li {
            color: #374151;
            margin-bottom: 0.25rem;
        }
        .dark .message-content li {
            color: #d1d5db;
        }
        .message-content li > p {
            margin-bottom: 0.5rem;
        }
        
        .message-content strong, .message-content b {
            font-weight: 600;
            color: #111827;
        }
        .dark .message-content strong, .dark .message-content b {
            color: #f9fafb;
        }
        .message-content em, .message-content i {
            font-style: italic;
        }
        
        .message-content code {
            background-color: #f3f4f6;
            padding: 0.125rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            color: #1f2937;
            border: 1px solid #e5e7eb;
        }
        .dark .message-content code {
            background-color: #374151;
            color: #e5e7eb;
            border-color: #4b5563;
        }
        
        .message-content pre {
            background-color: #f3f4f6;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
        }
        .dark .message-content pre {
            background-color: #374151;
            border-color: #4b5563;
        }
        .message-content pre code {
            background-color: transparent;
            padding: 0;
            border: 0;
        }
        
        .message-content blockquote {
            border-left: 4px solid #93c5fd;
            padding-left: 1rem;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            margin-top: 1rem;
            margin-bottom: 1rem;
            background-color: #eff6ff;
            font-style: italic;
            color: #4b5563;
            border-radius: 0 0.5rem 0.5rem 0;
        }
        .dark .message-content blockquote {
            border-left-color: #2563eb;
            background-color: rgba(37, 99, 235, 0.2);
            color: #9ca3af;
        }
        
        .message-content a {
            color: #2563eb;
            text-decoration: underline;
        }
        .dark .message-content a {
            color: #60a5fa;
        }
        .message-content a:hover {
            color: #1d4ed8;
        }
        .dark .message-content a:hover {
            color: #93c5fd;
        }
        
        .message-content hr {
            border: 0;
            border-top: 1px solid #d1d5db;
            margin: 1.5rem 0;
        }
        .dark .message-content hr {
            border-top-color: #4b5563;
        }
        
        .message-content table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #d1d5db;
            margin: 1rem 0;
        }
        .dark .message-content table {
            border-color: #4b5563;
        }
        .message-content th, .message-content td {
            border: 1px solid #d1d5db;
            padding: 0.75rem;
            text-align: left;
        }
        .dark .message-content th, .dark .message-content td {
            border-color: #4b5563;
        }
        .message-content th {
            background-color: #f3f4f6;
            font-weight: 600;
        }
        .dark .message-content th {
            background-color: #374151;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/easymde@2.18.0/dist/easymde.min.js"></script>
    <script>
        // Auto-refresh messages every 30 seconds
        let refreshInterval;
        
        function startAutoRefresh() {
            refreshInterval = setInterval(function() {
                // Only refresh if user is not actively typing in EasyMDE
                if (!easyMDE.codemirror.hasFocus()) {
                    refreshMessages();
                }
            }, 30000);
        }
        
        function refreshMessages() {
            fetch('{{ route("support-ticket::tickets.messages.index", $ticket) }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('messages-container').innerHTML = data.html;
                }
            })
            .catch(error => {
                console.error('Error refreshing messages:', error);
            });
        }
        
        
        
        // Handle form submission with EasyMDE validation
        document.getElementById('replyForm').addEventListener('submit', function(e) {
            if (easyMDE) {
                // Ensure EasyMDE content is synced to textarea
                easyMDE.codemirror.save();
                
                // Custom validation for EasyMDE
                const content = easyMDE.value().trim();
                if (!content) {
                    e.preventDefault();
                    showNotification('Message is required', 'error');
                    // Focus on EasyMDE editor
                    easyMDE.codemirror.focus();
                    return false;
                }
            }
        });
        
        // Notification function
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${
                type === 'success' ? 'bg-green-50 text-green-800 border border-green-200' :
                type === 'error' ? 'bg-red-50 text-red-800 border border-red-200' :
                type === 'warning' ? 'bg-yellow-50 text-yellow-800 border border-yellow-200' :
                'bg-blue-50 text-blue-800 border border-blue-200'
            }`;
            notification.textContent = message;
            
            // Add to page
            document.body.appendChild(notification);
            
            // Auto-remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 3000);
        }
        
        // Initialize EasyMDE and auto-refresh
        let easyMDE;
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize EasyMDE for reply message
            easyMDE = new EasyMDE({
                element: document.getElementById('message'),
                spellChecker: false,
                autofocus: false,
                placeholder: '{{ __("messages.type_your_reply") }}',
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
                status: ['autosave', 'lines', 'words', 'cursor'],
            });


            startAutoRefresh();
        });
        
        // Stop auto-refresh when user leaves the page
        window.addEventListener('beforeunload', function() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
        });
    </script>
    @endpush
</x-customer-account-layout::layout>