<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Blog Post</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update blog post with multilingual support</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('blog::admin.blog.show', $blog->slug) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Post
                    </a>
                    <a href="{{ route('blog::admin.blog.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('blog::admin.blog.update', $blog->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                               value="{{ old('english_title', $blog->english_title) }}"
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
                               value="{{ old('slug', $blog->slug) }}"
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
                            @foreach (\Modules\Blog\Models\Blog::getAvailableStatuses() as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $blog->status) === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Published At -->
                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Published At
                        </label>
                        <input type="datetime-local" 
                               id="published_at"
                               name="published_at"
                               value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('published_at')
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
                               value="{{ old('position', $blog->position) }}"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Order position (0 = first)">
                        @error('position')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tags -->
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tags
                    </label>
                    <select id="tags"
                            name="tags[]"
                            multiple
                            class="w-full">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $blog->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tags')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    @error('tags.*')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Featured Image -->
                <div>
                    <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Featured Image
                    </label>
                    
                    @if($blog->featured_image)
                        <div class="mb-3 p-3 border border-gray-200 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Current featured image:</p>
                            <img src="{{ $blog->featured_image }}" alt="Current featured image" class="w-32 h-32 object-cover rounded-md">
                        </div>
                    @endif
                    
                    <input type="file" 
                           id="featured_image"
                           name="featured_image"
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 2MB. Leave empty to keep current image.</p>
                    @error('featured_image')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Content Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Content</h3>

                    <!-- Language Tabs -->
                    <div class="border-b border-gray-200 dark:border-gray-600 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button type="button" 
                                    class="content-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400"
                                    data-tab="en" 
                                    data-active="true">
                                English Content
                            </button>
                            <button type="button" 
                                    class="content-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500"
                                    data-tab="bn" 
                                    data-active="false">
                                Bengali Content
                            </button>
                        </nav>
                    </div>

                    <!-- English Content Tab -->
                    <div id="content-tab-en" class="content-tab-panel">
                        <div class="space-y-4">
                            <!-- Title English -->
                            <div>
                                <label for="title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Title (English) *
                                </label>
                                <input type="text" 
                                       id="title_en"
                                       name="title[en]"
                                       value="{{ old('title.en', $blog->getTranslation('title', 'en')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Enter blog title in English"
                                       required>
                                @error('title.en')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Excerpt English -->
                            <div>
                                <label for="excerpt_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Excerpt (English)
                                </label>
                                <textarea id="excerpt_en"
                                          name="excerpt[en]"
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Brief description of the blog post">{{ old('excerpt.en', $blog->getTranslation('excerpt', 'en')) }}</textarea>
                                @error('excerpt.en')
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
                                          placeholder="Write your blog content in English"
                                          required>{{ old('content.en', $blog->getTranslation('content', 'en')) }}</textarea>
                                @error('content.en')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Bengali Content Tab -->
                    <div id="content-tab-bn" class="content-tab-panel hidden">
                        <div class="space-y-4">
                            <!-- Title Bengali -->
                            <div>
                                <label for="title_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Title (Bengali)
                                </label>
                                <input type="text" 
                                       id="title_bn"
                                       name="title[bn]"
                                       value="{{ old('title.bn', $blog->getTranslation('title', 'bn')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="ব্লগের শিরোনাম বাংলায় লিখুন">
                                @error('title.bn')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Excerpt Bengali -->
                            <div>
                                <label for="excerpt_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Excerpt (Bengali)
                                </label>
                                <textarea id="excerpt_bn"
                                          name="excerpt[bn]"
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="ব্লগ পোস্টের সংক্ষিপ্ত বিবরণ">{{ old('excerpt.bn', $blog->getTranslation('excerpt', 'bn')) }}</textarea>
                                @error('excerpt.bn')
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
                                          placeholder="আপনার ব্লগের বিষয়বস্তু বাংলায় লিখুন">{{ old('content.bn', $blog->getTranslation('content', 'bn')) }}</textarea>
                                @error('content.bn')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SEO Section -->
                <div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">SEO Settings</h3>

                    <!-- SEO Language Tabs -->
                    <div class="border-b border-gray-200 dark:border-gray-600 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button type="button" 
                                    class="seo-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400"
                                    data-tab="en" 
                                    data-active="true">
                                English SEO
                            </button>
                            <button type="button" 
                                    class="seo-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500"
                                    data-tab="bn" 
                                    data-active="false">
                                Bengali SEO
                            </button>
                        </nav>
                    </div>

                    <!-- English SEO Tab -->
                    <div id="seo-tab-en" class="seo-tab-panel mb-8">
                        <div class="space-y-4">
                            <!-- Meta Title English -->
                            <div>
                                <label for="meta_title_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Meta Title (English) <span class="text-xs text-gray-500">(60 characters max)</span>
                                </label>
                                <input type="text" 
                                       id="meta_title_en"
                                       name="meta_title[en]"
                                       value="{{ old('meta_title.en', $blog->getTranslation('meta_title', 'en')) }}"
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
                                          placeholder="Brief description that appears in search results">{{ old('meta_description.en', $blog->getTranslation('meta_description', 'en')) }}</textarea>
                                @error('meta_description.en')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Meta Keywords English -->
                            <div>
                                <label for="meta_keywords_en" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Meta Keywords (English) <span class="text-xs text-gray-500">(comma separated)</span>
                                </label>
                                <input type="text" 
                                       id="meta_keywords_en"
                                       name="meta_keywords[en]"
                                       value="{{ old('meta_keywords.en', $blog->getTranslation('meta_keywords', 'en')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="keyword1, keyword2, keyword3">
                                @error('meta_keywords.en')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Bengali SEO Tab -->
                    <div id="seo-tab-bn" class="seo-tab-panel mb-8 hidden">
                        <div class="space-y-4">
                            <!-- Meta Title Bengali -->
                            <div>
                                <label for="meta_title_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Meta Title (Bengali) <span class="text-xs text-gray-500">(60 characters max)</span>
                                </label>
                                <input type="text" 
                                       id="meta_title_bn"
                                       name="meta_title[bn]"
                                       value="{{ old('meta_title.bn', $blog->getTranslation('meta_title', 'bn')) }}"
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
                                          placeholder="সার্চ রেজাল্টে দেখানো সংক্ষিপ্ত বিবরণ">{{ old('meta_description.bn', $blog->getTranslation('meta_description', 'bn')) }}</textarea>
                                @error('meta_description.bn')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Meta Keywords Bengali -->
                            <div>
                                <label for="meta_keywords_bn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Meta Keywords (Bengali) <span class="text-xs text-gray-500">(comma separated)</span>
                                </label>
                                <input type="text" 
                                       id="meta_keywords_bn"
                                       name="meta_keywords[bn]"
                                       value="{{ old('meta_keywords.bn', $blog->getTranslation('meta_keywords', 'bn')) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="কীওয়ার্ড১, কীওয়ার্ড২, কীওয়ার্ড৩">
                                @error('meta_keywords.bn')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- General SEO Settings -->
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-md font-medium text-gray-800 dark:text-gray-100 mb-4">General SEO Settings</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Canonical URL -->
                            <div>
                                <label for="canonical_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Canonical URL
                                </label>
                                <input type="url" 
                                       id="canonical_url"
                                       name="canonical_url"
                                       value="{{ old('canonical_url', $blog->canonical_url) }}"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="https://example.com/canonical-url">
                                @error('canonical_url')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SEO Directives -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Search Engine Directives
                                </label>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <input id="noindex" 
                                               name="noindex" 
                                               type="checkbox" 
                                               value="1"
                                               {{ old('noindex', $blog->noindex) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="noindex" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            No Index (prevent indexing by search engines)
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="nofollow" 
                                               name="nofollow" 
                                               type="checkbox" 
                                               value="1"
                                               {{ old('nofollow', $blog->nofollow) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="nofollow" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                            No Follow (prevent following links on this page)
                                        </label>
                                    </div>
                                </div>
                                @error('noindex')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                @error('nofollow')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('blog::admin.blog.index') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Blog Post
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde@2.18.0/dist/easymde.min.css">
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
        
        /* Select2 Dark Mode Styles */
        .dark .select2-container--default .select2-selection--multiple {
            background-color: rgb(55 65 81) !important;
            border-color: rgb(75 85 99) !important;
            color: rgb(243 244 246) !important;
        }
        .dark .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: rgb(59 130 246) !important;
            border-color: rgb(37 99 235) !important;
            color: white !important;
        }
        .dark .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        .dark .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: white !important;
        }
        .dark .select2-dropdown {
            background-color: rgb(55 65 81) !important;
            border-color: rgb(75 85 99) !important;
        }
        .dark .select2-container--default .select2-results__option {
            color: rgb(243 244 246) !important;
        }
        .dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: rgb(59 130 246) !important;
        }
        .dark .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: rgb(75 85 99) !important;
            border-color: rgb(107 114 128) !important;
            color: rgb(243 244 246) !important;
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
                placeholder: 'Write your blog content in English...',
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
                placeholder: 'আপনার ব্লগের বিষয়বস্তু বাংলায় লিখুন...',
                renderingConfig: {
                    singleLineBreaks: false,
                    codeSyntaxHighlighting: true,
                },
            });

            // Initialize Select2 for tags
            $('#tags').select2({
                placeholder: 'Select tags...',
                allowClear: true,
                width: '100%',
                tags: true,
                tokenSeparators: [',', ' '],
                createTag: function (params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true
                    };
                }
            });

            // Auto-generate slug from english_title (only if slug is empty or was auto-generated)
            const englishTitleInput = document.getElementById('english_title');
            const slugInput = document.getElementById('slug');
            let manualSlugEdit = false;

            // Check if slug was manually edited
            slugInput.addEventListener('input', function() {
                manualSlugEdit = true;
            });

            // Auto-generate slug when english_title changes
            englishTitleInput.addEventListener('input', function() {
                // Only auto-generate if slug wasn't manually edited
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

            // Content Tab functionality
            const contentTabButtons = document.querySelectorAll('.content-tab-btn');
            const contentTabPanels = document.querySelectorAll('.content-tab-panel');

            contentTabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Update button states
                    contentTabButtons.forEach(btn => {
                        btn.setAttribute('data-active', 'false');
                        btn.className = 'content-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500';
                    });
                    
                    this.setAttribute('data-active', 'true');
                    this.className = 'content-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400';
                    
                    // Update panel visibility
                    contentTabPanels.forEach(panel => {
                        panel.classList.add('hidden');
                    });
                    
                    document.getElementById(`content-tab-${targetTab}`).classList.remove('hidden');
                });
            });

            // SEO Tab functionality
            const seoTabButtons = document.querySelectorAll('.seo-tab-btn');
            const seoTabPanels = document.querySelectorAll('.seo-tab-panel');

            seoTabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    
                    // Update button states
                    seoTabButtons.forEach(btn => {
                        btn.setAttribute('data-active', 'false');
                        btn.className = 'seo-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-500';
                    });
                    
                    this.setAttribute('data-active', 'true');
                    this.className = 'seo-tab-btn py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400';
                    
                    // Update panel visibility
                    seoTabPanels.forEach(panel => {
                        panel.classList.add('hidden');
                    });
                    
                    document.getElementById(`seo-tab-${targetTab}`).classList.remove('hidden');
                });
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