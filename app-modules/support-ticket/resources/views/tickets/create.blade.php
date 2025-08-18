<x-customer-account-layout::layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('support-ticket::tickets.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('messages.create_support_ticket') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Help Text Section -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ __('messages.before_creating_ticket') }}</h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>{{ __('messages.provide_detailed_description') }}</li>
                                <li>{{ __('messages.select_appropriate_category') }}</li>
                                <li>{{ __('messages.we_respond_within_24_hours') }}</li>
                                <li>{{ __('messages.track_ticket_progress') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Ticket Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 rounded-md p-4">
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

                    <form action="{{ route('support-ticket::tickets.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Ticket Subject -->
                        <div class="relative">
                            <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('messages.ticket_subject') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       value="{{ old('title') }}" 
                                       required
                                       maxlength="255"
                                       placeholder="{{ __('messages.enter_ticket_subject') }}"
                                       class="block w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out shadow-sm hover:border-gray-400 dark:hover:border-gray-500">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('messages.brief_summary_of_issue') }}
                            </p>
                        </div>

                        <!-- Category Selection -->
                        <div class="relative">
                            <label for="category" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('messages.category') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="category" 
                                        id="category" 
                                        required
                                        class="block w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out shadow-sm hover:border-gray-400 dark:hover:border-gray-500 appearance-none cursor-pointer">
                                    <option value="">{{ __('messages.select_category') }}</option>
                                    <option value="general" {{ old('category') === 'general' ? 'selected' : '' }}>{{ __('messages.ticket_category_general') }}</option>
                                    <option value="technical" {{ old('category') === 'technical' ? 'selected' : '' }}>{{ __('messages.ticket_category_technical') }}</option>
                                    <option value="billing" {{ old('category') === 'billing' ? 'selected' : '' }}>{{ __('messages.ticket_category_billing') }}</option>
                                    <option value="feature_request" {{ old('category') === 'feature_request' ? 'selected' : '' }}>{{ __('messages.ticket_category_feature_request') }}</option>
                                    <option value="bug_report" {{ old('category') === 'bug_report' ? 'selected' : '' }}>{{ __('messages.ticket_category_bug_report') }}</option>
                                    <option value="account" {{ old('category') === 'account' ? 'selected' : '' }}>{{ __('messages.ticket_category_account') }}</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('category')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                {{ __('messages.help_us_route_ticket') }}
                            </p>
                        </div>

                        <!-- Priority (Optional) -->
                        <div class="relative">
                            <label for="priority" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('messages.priority') }}
                            </label>
                            <div class="relative">
                                <select name="priority" 
                                        id="priority"
                                        class="block w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out shadow-sm hover:border-gray-400 dark:hover:border-gray-500 appearance-none cursor-pointer">
                                    <option value="normal" {{ old('priority', 'normal') === 'normal' ? 'selected' : '' }}>{{ __('messages.ticket_priority_normal') }}</option>
                                    <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>{{ __('messages.ticket_priority_low') }}</option>
                                    <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>{{ __('messages.ticket_priority_high') }}</option>
                                    <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>{{ __('messages.ticket_priority_urgent') }}</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('priority')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('messages.urgency_level_help') }}
                            </p>
                        </div>

                        <!-- Detailed Description -->
                        <div class="relative">
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                {{ __('messages.detailed_description') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <textarea name="description" 
                                          id="description" 
                                          rows="10" 
                                          required
                                          placeholder="{{ __('messages.describe_issue_detail') }}"
                                          class="block w-full px-4 py-3 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 ease-in-out shadow-sm hover:border-gray-400 dark:hover:border-gray-500">{{ old('description') }}</textarea>
                            </div>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                {{ __('messages.include_steps_to_reproduce') }}
                            </p>
                        </div>

                        <!-- Tips for Better Support -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.tips_for_better_support') }}</h4>
                            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                <li>• {{ __('messages.tip_specific_details') }}</li>
                                <li>• {{ __('messages.tip_error_messages') }}</li>
                                <li>• {{ __('messages.tip_screenshots') }}</li>
                                <li>• {{ __('messages.tip_browser_device') }}</li>
                                <li>• {{ __('messages.tip_steps_taken') }}</li>
                            </ul>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('support-ticket::tickets.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                {{ __('messages.cancel') }}
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ __('messages.create_ticket') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.need_immediate_help') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.email_support') }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ config('support.email') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.response_within_24_hours') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-gray-400 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.live_chat') }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.available_business_hours') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.mon_fri_9am_6pm') }}</p>
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
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/easymde@2.18.0/dist/easymde.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize EasyMDE for description
            const easyMDE = new EasyMDE({
                element: document.getElementById('description'),
                spellChecker: false,
                autofocus: false,
                placeholder: '{{ __("messages.describe_issue_detail") }}',
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

            const categorySelect = document.getElementById('category');
            const prioritySelect = document.getElementById('priority');
            
            // Auto-adjust priority based on category
            categorySelect.addEventListener('change', function() {
                const category = this.value;
                
                if (category === 'bug_report' || category === 'technical') {
                    // Suggest higher priority for technical issues
                    if (prioritySelect.value === 'normal' || prioritySelect.value === 'low') {
                        prioritySelect.value = 'high';
                    }
                } else if (category === 'billing') {
                    // Billing issues are usually important
                    if (prioritySelect.value === 'low') {
                        prioritySelect.value = 'normal';
                    }
                }
            });

            // Character count for title
            const titleInput = document.getElementById('title');
            let titleCounter = document.createElement('div');
            titleCounter.className = 'text-xs text-gray-500 dark:text-gray-400 mt-1 text-right';
            titleInput.parentNode.appendChild(titleCounter);
            
            function updateTitleCounter() {
                const length = titleInput.value.length;
                const maxLength = titleInput.getAttribute('maxlength');
                titleCounter.textContent = `${length}/${maxLength} {{ __('messages.characters') }}`;
                
                if (length > maxLength * 0.9) {
                    titleCounter.classList.add('text-red-500');
                    titleCounter.classList.remove('text-gray-500', 'dark:text-gray-400');
                } else {
                    titleCounter.classList.remove('text-red-500');
                    titleCounter.classList.add('text-gray-500', 'dark:text-gray-400');
                }
            }
            
            titleInput.addEventListener('input', updateTitleCounter);
            updateTitleCounter();

            // Auto-save form data to localStorage
            const formElements = ['title', 'category', 'priority', 'description'];
            const formKey = 'support_ticket_draft';
            
            // Load saved data
            const savedData = localStorage.getItem(formKey);
            if (savedData) {
                try {
                    const data = JSON.parse(savedData);
                    formElements.forEach(field => {
                        if (data[field] && document.getElementById(field)) {
                            document.getElementById(field).value = data[field];
                        }
                    });
                } catch (e) {
                    // Invalid saved data, ignore
                }
            }
            
            // Save data on input
            formElements.forEach(field => {
                const element = document.getElementById(field);
                if (element) {
                    element.addEventListener('input', function() {
                        const data = {};
                        formElements.forEach(f => {
                            const el = document.getElementById(f);
                            if (el) data[f] = el.value;
                        });
                        localStorage.setItem(formKey, JSON.stringify(data));
                    });
                }
            });
            
            // Clear saved data on form submit and sync EasyMDE
            document.querySelector('form').addEventListener('submit', function() {
                // Ensure EasyMDE content is synced to textarea
                easyMDE.codemirror.save();
                localStorage.removeItem(formKey);
            });
        });
    </script>
    @endpush
</x-customer-account-layout::layout>