<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Page</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update page with multilingual support</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('page::admin.pages.show', $page->slug) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Page
                    </a>
                    <a href="{{ route('page::admin.pages.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('page::admin.pages.update', $page->slug) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- English Title -->
                    <div>
                        <label for="english_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            English Title *
                        </label>
                        <input type="text" 
                               id="english_title"
                               name="english_title"
                               value="{{ old('english_title', $page->english_title) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter English title for slug generation"
                               required>
                        @error('english_title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Slug (Auto-generated, can be changed)
                        </label>
                        <input type="text" 
                               id="slug"
                               name="slug"
                               value="{{ old('slug', $page->slug) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Auto-generated from English title">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Other Fields -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status *
                        </label>
                        <select id="status" 
                                name="status"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $page->status) === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Template -->
                    <div>
                        <label for="template" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Template
                        </label>
                        <select id="template" 
                                name="template"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @foreach ($templates as $value => $label)
                                <option value="{{ $value }}" {{ old('template', $page->template ?: 'default') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Choose a template or use default content rendering</p>
                        @error('template')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Position -->
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Position
                        </label>
                        <input type="number" 
                               id="position"
                               name="position"
                               value="{{ old('position', $page->position) }}"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Order position (0 = first)">
                        @error('position')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Published At -->
                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Published At
                    </label>
                    <input type="datetime-local" 
                           id="published_at"
                           name="published_at"
                           value="{{ old('published_at', $page->published_at ? $page->published_at->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('published_at')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Content and SEO Tabs -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button type="button" 
                                class="main-tab active whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400"
                                data-tab="content">
                            Content
                        </button>
                        <button type="button" 
                                class="main-tab whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500"
                                data-tab="seo">
                            SEO Settings
                        </button>
                    </nav>
                </div>

                <!-- Content Tab -->
                <div id="tab-content" class="main-content">
                    <!-- Language Tabs -->
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <button type="button" 
                                    class="language-tab active whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400"
                                    data-lang="en">
                                English
                            </button>
                            <button type="button" 
                                    class="language-tab whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500"
                                    data-lang="bn">
                                Bengali
                            </button>
                        </nav>
                    </div>

                    <!-- English Fields -->
                    <div id="lang-en" class="language-content">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">English Content</h3>
                        
                        <div class="space-y-4">
                            <!-- Title English -->
                            <div>
                                <label for="title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Title (English) *
                                </label>
                                <input type="text" 
                                       id="title_en"
                                       name="title[en]"
                                       value="{{ old('title.en', $page->getTranslation('title', 'en')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter page title in English"
                                       required>
                                @error('title.en')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Content English -->
                            <div>
                                <label for="content_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Content (English) *
                                </label>
                                <textarea id="content_en"
                                          name="content[en]"
                                          rows="12"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Write your page content in English"
                                          required>{{ old('content.en', $page->getTranslation('content', 'en')) }}</textarea>
                                @error('content.en')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Bengali Fields -->
                    <div id="lang-bn" class="language-content hidden">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Bengali Content</h3>
                        
                        <div class="space-y-4">
                            <!-- Title Bengali -->
                            <div>
                                <label for="title_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Title (Bengali)
                                </label>
                                <input type="text" 
                                       id="title_bn"
                                       name="title[bn]"
                                       value="{{ old('title.bn', $page->getTranslation('title', 'bn')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="পেজের শিরোনাম বাংলায় লিখুন">
                                @error('title.bn')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Content Bengali -->
                            <div>
                                <label for="content_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Content (Bengali)
                                </label>
                                <textarea id="content_bn"
                                          name="content[bn]"
                                          rows="12"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="আপনার পেজের বিষয়বস্তু বাংলায় লিখুন">{{ old('content.bn', $page->getTranslation('content', 'bn')) }}</textarea>
                                @error('content.bn')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Tab -->
                <div id="tab-seo" class="main-content hidden">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4 mt-6">SEO Settings</h3>

                    <!-- SEO Language Tabs -->
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <button type="button" 
                                    class="seo-language-tab active whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400"
                                    data-lang="en">
                                English SEO
                            </button>
                            <button type="button" 
                                    class="seo-language-tab whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500"
                                    data-lang="bn">
                                Bengali SEO
                            </button>
                        </nav>
                    </div>

                    <!-- English SEO Fields -->
                    <div id="seo-lang-en" class="seo-language-content mt-6">
                        <div class="space-y-4">
                            <!-- Meta Title English -->
                            <div>
                                <label for="meta_title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Meta Title (English) <span class="text-xs text-gray-500">(60 characters max)</span>
                                </label>
                                <input type="text" 
                                       id="meta_title_en"
                                       name="meta_title[en]"
                                       value="{{ old('meta_title.en', $page->getTranslation('meta_title', 'en')) }}"
                                       maxlength="60"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="SEO optimized title for search engines">
                                @error('meta_title.en')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Meta Description English -->
                            <div>
                                <label for="meta_description_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Meta Description (English) <span class="text-xs text-gray-500">(160 characters max)</span>
                                </label>
                                <textarea id="meta_description_en"
                                          name="meta_description[en]"
                                          rows="3"
                                          maxlength="160"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Brief description that appears in search results">{{ old('meta_description.en', $page->getTranslation('meta_description', 'en')) }}</textarea>
                                @error('meta_description.en')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Keywords English -->
                            <div>
                                <label for="keywords_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Keywords (English) <span class="text-xs text-gray-500">(comma separated)</span>
                                </label>
                                <input type="text" 
                                       id="keywords_en"
                                       name="keywords[en]"
                                       value="{{ old('keywords.en', $page->getTranslation('keywords', 'en')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="keyword1, keyword2, keyword3">
                                @error('keywords.en')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Bengali SEO Fields -->
                    <div id="seo-lang-bn" class="seo-language-content hidden mt-6">
                        <div class="space-y-4">
                            <!-- Meta Title Bengali -->
                            <div>
                                <label for="meta_title_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Meta Title (Bengali) <span class="text-xs text-gray-500">(60 characters max)</span>
                                </label>
                                <input type="text" 
                                       id="meta_title_bn"
                                       name="meta_title[bn]"
                                       value="{{ old('meta_title.bn', $page->getTranslation('meta_title', 'bn')) }}"
                                       maxlength="60"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="সার্চ ইঞ্জিনের জন্য SEO অপ্টিমাইজড শিরোনাম">
                                @error('meta_title.bn')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Meta Description Bengali -->
                            <div>
                                <label for="meta_description_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Meta Description (Bengali) <span class="text-xs text-gray-500">(160 characters max)</span>
                                </label>
                                <textarea id="meta_description_bn"
                                          name="meta_description[bn]"
                                          rows="3"
                                          maxlength="160"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="সার্চ রেজাল্টে দেখানো সংক্ষিপ্ত বিবরণ">{{ old('meta_description.bn', $page->getTranslation('meta_description', 'bn')) }}</textarea>
                                @error('meta_description.bn')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Keywords Bengali -->
                            <div>
                                <label for="keywords_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Keywords (Bengali) <span class="text-xs text-gray-500">(comma separated)</span>
                                </label>
                                <input type="text" 
                                       id="keywords_bn"
                                       name="keywords[bn]"
                                       value="{{ old('keywords.bn', $page->getTranslation('keywords', 'bn')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="কীওয়ার্ড১, কীওয়ার্ড২, কীওয়ার্ড৩">
                                @error('keywords.bn')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('page::admin.pages.show', $page->slug) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Page
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde@2.18.0/dist/easymde.min.css">
    <style>
        .language-tab, .main-tab, .seo-language-tab {
            @apply border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300;
        }
        .language-tab.active, .main-tab.active, .seo-language-tab.active {
            @apply border-blue-500 text-blue-600;
        }
        .dark .language-tab, .dark .main-tab, .dark .seo-language-tab {
            @apply text-gray-400 hover:text-gray-200 hover:border-gray-500;
        }
        .dark .language-tab.active, .dark .main-tab.active, .dark .seo-language-tab.active {
            @apply border-blue-400 text-blue-400;
        }
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
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/easymde@2.18.0/dist/easymde.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize EasyMDE for English content
            const easyMDE_en = new EasyMDE({
                element: document.getElementById('content_en'),
                spellChecker: false,
                autofocus: false,
                placeholder: 'Write your page content in English...',
                renderingConfig: {
                    singleLineBreaks: false,
                    codeSyntaxHighlighting: true,
                },
            });

            // Initialize EasyMDE for Bengali content
            const easyMDE_bn = new EasyMDE({
                element: document.getElementById('content_bn'),
                spellChecker: false,
                autofocus: false,
                placeholder: 'আপনার পেজের বিষয়বস্তু বাংলায় লিখুন...',
                renderingConfig: {
                    singleLineBreaks: false,
                    codeSyntaxHighlighting: true,
                },
            });

            // Main tab functionality
            const mainTabs = document.querySelectorAll('.main-tab');
            const mainContents = document.querySelectorAll('.main-content');

            mainTabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetTab = this.dataset.tab;
                    
                    // Update main tab states
                    mainTabs.forEach(t => {
                        t.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:border-blue-400', 'dark:text-blue-400');
                        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-200', 'dark:hover:border-gray-500');
                    });
                    
                    this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-200', 'dark:hover:border-gray-500');
                    this.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:border-blue-400', 'dark:text-blue-400');
                    
                    // Update main content visibility
                    mainContents.forEach(content => {
                        if (content.id === `tab-${targetTab}`) {
                            content.classList.remove('hidden');
                        } else {
                            content.classList.add('hidden');
                        }
                    });
                });
            });

            // Language tab functionality (for content tab)
            const languageTabs = document.querySelectorAll('.language-tab');
            const languageContents = document.querySelectorAll('.language-content');

            languageTabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetLang = this.dataset.lang;
                    
                    // Update tab states
                    languageTabs.forEach(t => {
                        t.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:border-blue-400', 'dark:text-blue-400');
                        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-200', 'dark:hover:border-gray-500');
                    });
                    
                    this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-200', 'dark:hover:border-gray-500');
                    this.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:border-blue-400', 'dark:text-blue-400');
                    
                    // Update content visibility
                    languageContents.forEach(content => {
                        if (content.id === `lang-${targetLang}`) {
                            content.classList.remove('hidden');
                        } else {
                            content.classList.add('hidden');
                        }
                    });
                    
                    // Refresh EasyMDE instances
                    setTimeout(() => {
                        if (targetLang === 'en') {
                            easyMDE_en.codemirror.refresh();
                        } else {
                            easyMDE_bn.codemirror.refresh();
                        }
                    }, 100);
                });
            });

            // SEO Language tab functionality (for SEO tab)
            const seoLanguageTabs = document.querySelectorAll('.seo-language-tab');
            const seoLanguageContents = document.querySelectorAll('.seo-language-content');

            seoLanguageTabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetLang = this.dataset.lang;
                    
                    // Update SEO language tab states
                    seoLanguageTabs.forEach(t => {
                        t.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:border-blue-400', 'dark:text-blue-400');
                        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-200', 'dark:hover:border-gray-500');
                    });
                    
                    this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-200', 'dark:hover:border-gray-500');
                    this.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:border-blue-400', 'dark:text-blue-400');
                    
                    // Update SEO language content visibility
                    seoLanguageContents.forEach(content => {
                        if (content.id === `seo-lang-${targetLang}`) {
                            content.classList.remove('hidden');
                        } else {
                            content.classList.add('hidden');
                        }
                    });
                });
            });

            // Auto-generate slug from english_title (but not overwrite existing)
            const englishTitleInput = document.getElementById('english_title');
            const slugInput = document.getElementById('slug');
            let manualSlugEdit = false;
            const originalSlug = slugInput.value; // Store original slug

            // Check if slug was manually edited
            slugInput.addEventListener('input', function() {
                if (this.value !== originalSlug) {
                    manualSlugEdit = true;
                }
            });

            // Auto-generate slug when english_title changes (only if not manually edited)
            englishTitleInput.addEventListener('input', function() {
                if (!manualSlugEdit) {
                    const slug = this.value
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim('-');
                    slugInput.value = slug;
                }
            });

            // Handle form submission
            document.querySelector('form').addEventListener('submit', function() {
                // EasyMDE automatically syncs with the textarea, but let's be explicit
                easyMDE_en.codemirror.save();
                easyMDE_bn.codemirror.save();
            });
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>