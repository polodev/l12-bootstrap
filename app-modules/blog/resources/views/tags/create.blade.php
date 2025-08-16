<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Create New Tag</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Add a new tag for blog posts</p>
                </div>
                <a href="{{ route('blog::admin.tags.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Tags
                </a>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('blog::admin.tags.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- English Name (for slug generation) -->
                <div>
                    <label for="english_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        English Name *
                    </label>
                    <input type="text" 
                           id="english_name"
                           name="english_name"
                           value="{{ old('english_name') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter English name for slug generation"
                           required>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">This will be used to generate the URL slug</p>
                    @error('english_name')
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
                           value="{{ old('slug') }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Auto-generated from English name">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

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
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">English Display Name</h3>
                    
                    <div>
                        <label for="name_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Display Name (English) *
                        </label>
                        <input type="text" 
                               id="name_en"
                               name="name[en]"
                               value="{{ old('name.en') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Enter display name in English"
                               required>
                        @error('name.en')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Bengali Fields -->
                <div id="lang-bn" class="language-content hidden">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Bengali Display Name</h3>
                    
                    <div>
                        <label for="name_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Display Name (Bengali)
                        </label>
                        <input type="text" 
                               id="name_bn"
                               name="name[bn]"
                               value="{{ old('name.bn') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="ট্যাগের নাম বাংলায় লিখুন">
                        @error('name.bn')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('blog::admin.tags.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Tag
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <style>
        .language-tab {
            @apply border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300;
        }
        .language-tab.active {
            @apply border-blue-500 text-blue-600;
        }
        .dark .language-tab {
            @apply text-gray-400 hover:text-gray-200 hover:border-gray-500;
        }
        .dark .language-tab.active {
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

            // Auto-generate slug from english_name
            const englishNameInput = document.getElementById('english_name');
            const slugInput = document.getElementById('slug');
            let manualSlugEdit = false;

            // Check if slug was manually edited
            slugInput.addEventListener('input', function() {
                manualSlugEdit = true;
            });

            // Auto-generate slug when english_name changes
            englishNameInput.addEventListener('input', function() {
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
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>