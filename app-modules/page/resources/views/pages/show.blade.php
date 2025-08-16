<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Page Details</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">View page information and content</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('page::pages.show', $page->slug) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2M7 7h10l-4 4M7 7l4 4"></path>
                        </svg>
                        View Page
                    </a>
                    <a href="{{ route('page::admin.pages.edit', $page->slug) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Page
                    </a>
                    <form method="POST" action="{{ route('page::admin.pages.destroy', $page->slug) }}" class="inline-block" 
                          onsubmit="return confirm('Are you sure you want to delete this page? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Page
                        </button>
                    </form>
                    <a href="{{ route('page::admin.pages.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Pages
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-800 dark:border-green-600 dark:text-green-100" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Page Information -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Basic Info -->
                <div class="lg:col-span-2 bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Basic Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">English Title</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $page->english_title }}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title (English)</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $page->getTranslation('title', 'en') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title (Bengali)</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $page->getTranslation('title', 'bn') ?: 'Not set' }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono bg-gray-100 dark:bg-gray-600 px-2 py-1 rounded">{{ $page->slug }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Template</label>
                            @if(!$page->template || $page->template === 'default')
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Default (Content Only)</p>
                            @else
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                        {{ $page->template }}
                                    </span>
                                    @if($page->hasTemplate())
                                        <span class="ml-2 text-green-600 dark:text-green-400 text-xs">✓ Template file exists</span>
                                    @else
                                        <span class="ml-2 text-red-600 dark:text-red-400 text-xs">✗ Template file not found</span>
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Status & Meta -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Status & Metadata</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <p class="mt-1">{!! $page->status_badge !!}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Published At</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $page->published_at ? $page->published_at->format('M d, Y H:i') : 'Not published' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $page->position }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Created</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $page->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $page->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Page Content</h3>
                
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

                <!-- English Content -->
                <div id="lang-en" class="language-content mt-6">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <div class="prose max-w-none dark:prose-invert">
                            {!! nl2br(e($page->getTranslation('content', 'en'))) !!}
                        </div>
                    </div>
                </div>

                <!-- Bengali Content -->
                <div id="lang-bn" class="language-content hidden mt-6">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        @if($page->getTranslation('content', 'bn'))
                            <div class="prose max-w-none dark:prose-invert">
                                {!! nl2br(e($page->getTranslation('content', 'bn'))) !!}
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 italic">No Bengali content available</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">SEO Information</h3>
                
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

                <!-- English SEO -->
                <div id="seo-lang-en" class="seo-language-content mt-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Title</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $page->getTranslation('meta_title', 'en') ?: 'Not set' }}
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keywords</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $page->getTranslation('keywords', 'en') ?: 'Not set' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Description</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $page->getTranslation('meta_description', 'en') ?: 'Not set' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bengali SEO -->
                <div id="seo-lang-bn" class="seo-language-content hidden mt-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Title</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $page->getTranslation('meta_title', 'bn') ?: 'Not set' }}
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keywords</label>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $page->getTranslation('keywords', 'bn') ?: 'Not set' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Meta Description</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $page->getTranslation('meta_description', 'bn') ?: 'Not set' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .language-tab, .seo-language-tab {
            @apply border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300;
        }
        .language-tab.active, .seo-language-tab.active {
            @apply border-blue-500 text-blue-600;
        }
        .dark .language-tab, .dark .seo-language-tab {
            @apply text-gray-400 hover:text-gray-200 hover:border-gray-500;
        }
        .dark .language-tab.active, .dark .seo-language-tab.active {
            @apply border-blue-400 text-blue-400;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Language tab functionality
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
                });
            });

            // SEO Language tab functionality
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
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>