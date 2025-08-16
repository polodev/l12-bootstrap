<x-customer-frontend-layout::layout>
    <x-slot name="title">{{ $blog->getTranslation('title', app()->getLocale()) }}</x-slot>
    <x-slot name="description">{{ $blog->getTranslation('excerpt', app()->getLocale()) ?: strip_tags(Str::limit($blog->getTranslation('content', app()->getLocale()), 160)) }}</x-slot>

    <div class="min-h-screen bg-white dark:bg-gray-900">
        <!-- Hero Section -->
        <div class="hero-gradient text-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <!-- Breadcrumb -->
                <nav class="mb-8">
                    <ol class="flex items-center space-x-2 text-sm text-white/80">
                        <li>
                            <a href="{{ route('blog::blog.index') }}" class="hover:text-white transition-colors">
                                {{ __('messages.blog') }}
                            </a>
                        </li>
                        <li class="text-white/60">/</li>
                        <li class="text-white">{{ $blog->getTranslation('title', app()->getLocale()) }}</li>
                    </ol>
                </nav>

                <!-- Blog Header -->
                <div class="space-y-4">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                        {{ $blog->getTranslation('title', app()->getLocale()) }}
                    </h1>
                    
                    @if($blog->getTranslation('excerpt', app()->getLocale()))
                        <p class="text-xl text-white/90 leading-relaxed max-w-3xl">
                            {{ $blog->getTranslation('excerpt', app()->getLocale()) }}
                        </p>
                    @endif

                    <!-- Meta Information -->
                    <div class="flex items-center space-x-6 text-white/80">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 10h6a2 2 0 002-2V7H6v8a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ $blog->published_at->format('F d, Y') }}</span>
                        </div>
                        
                        @if($blog->tags->isNotEmpty())
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($blog->tags->take(3) as $tag)
                                        <a href="{{ route('blog::blog.tags.show', $tag->slug) }}" 
                                           class="text-white/80 hover:text-white transition-colors">
                                            {{ $tag->name }}{{ !$loop->last ? ',' : '' }}
                                        </a>
                                    @endforeach
                                    @if($blog->tags->count() > 3)
                                        <span class="text-white/60">+{{ $blog->tags->count() - 3 }} more</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
                <!-- Article Content -->
                <article class="lg:col-span-3">
                    <!-- Featured Image -->
                    @if($blog->featured_image)
                        <div class="mb-8">
                            <img src="{{ $blog->featured_image }}" 
                                 alt="{{ $blog->getTranslation('title', app()->getLocale()) }}"
                                 class="w-full h-64 md:h-96 object-cover rounded-lg shadow-lg">
                        </div>
                    @endif

                    <!-- Article Body -->
                    <article class="prose prose-base sm:prose-lg max-w-none dark:prose-invert prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-gray-100 prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-p:leading-relaxed prose-li:text-gray-700 dark:prose-li:text-gray-300 prose-strong:text-gray-900 dark:prose-strong:text-gray-100 prose-code:text-red-600 dark:prose-code:text-red-400 prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:text-sm prose-pre:bg-gray-50 dark:prose-pre:bg-gray-900 prose-pre:border prose-pre:border-gray-200 dark:prose-pre:border-gray-700 prose-blockquote:border-l-4 prose-blockquote:border-eco-green prose-blockquote:bg-eco-green/5 dark:prose-blockquote:bg-eco-green/10 prose-blockquote:pl-6 prose-blockquote:py-4 prose-blockquote:rounded-r prose-a:text-eco-green dark:prose-a:text-eco-green prose-a:no-underline hover:prose-a:underline prose-img:rounded-lg prose-img:shadow-lg" id="blog-content">
                        {!! Str::markdown($blog->getTranslation('content', app()->getLocale())) !!}
                    </article>

                    <!-- Tags Section -->
                    @if($blog->tags->isNotEmpty())
                        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.tags') }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($blog->tags as $tag)
                                    <a href="{{ route('blog::blog.tags.show', $tag->slug) }}" 
                                       class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-eco-green/10 text-eco-green dark:bg-eco-green/20 dark:text-eco-green hover:bg-eco-green/20 dark:hover:bg-eco-green/30 transition-colors">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Social Share -->
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.share_this_post') }}</h3>
                        <div class="flex space-x-4">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->getTranslation('title', app()->getLocale())) }}" 
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-eco-green text-white rounded-lg hover:bg-eco-green-dark transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                                Twitter
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank"
                               class="inline-flex items-center px-4 py-2 bg-eco-green text-white rounded-lg hover:bg-eco-green-dark transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </a>
                            <button onclick="copyToClipboard('{{ request()->url() }}')" 
                                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('messages.copy_link') }}
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="sticky top-8 space-y-8">
                        <!-- Related Posts -->
                        @if($relatedBlogs->isNotEmpty())
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.related_posts') }}</h3>
                                <div class="space-y-4">
                                    @foreach($relatedBlogs as $relatedBlog)
                                        <article class="group">
                                            <a href="{{ route('blog::blog.show', $relatedBlog->slug) }}" class="block">
                                                @if($relatedBlog->featured_image)
                                                    <img src="{{ $relatedBlog->featured_image }}" 
                                                         alt="{{ $relatedBlog->getTranslation('title', app()->getLocale()) }}"
                                                         class="w-full h-32 object-cover rounded-lg mb-3 group-hover:opacity-90 transition-opacity">
                                                @endif
                                                <h4 class="font-medium text-gray-900 dark:text-gray-100 group-hover:text-eco-green dark:group-hover:text-eco-green transition-colors line-clamp-2">
                                                    {{ $relatedBlog->getTranslation('title', app()->getLocale()) }}
                                                </h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $relatedBlog->published_at->format('M d, Y') }}
                                                </p>
                                            </a>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Back to Blog -->
                        <div class="bg-eco-green/5 dark:bg-eco-green/10 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.explore_more') }}</h3>
                            <a href="{{ route('blog::blog.index') }}" 
                               class="inline-flex items-center text-eco-green dark:text-eco-green hover:text-eco-green-dark dark:hover:text-eco-green-dark font-medium">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ __('messages.all_blog_posts') }}
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github.min.css" media="(prefers-color-scheme: light)">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github-dark.min.css" media="(prefers-color-scheme: dark)">
    <style>
        /* Enhanced prose styles for beautiful blog content */
        .prose {
            line-height: 1.75;
            font-family: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;
        }
        
        /* Heading improvements */
        .prose h1 {
            font-size: 2.25rem;
            line-height: 1.2;
            margin-top: 0;
            margin-bottom: 2rem;
            color: rgb(17 24 39);
            border-bottom: 3px solid rgb(59 130 246);
            padding-bottom: 0.5rem;
        }
        .dark .prose h1 {
            color: rgb(243 244 246);
            border-bottom-color: rgb(96 165 250);
        }
        
        .prose h2 {
            font-size: 1.875rem;
            line-height: 1.3;
            margin-top: 3rem;
            margin-bottom: 1.5rem;
            color: rgb(31 41 55);
            position: relative;
        }
        .dark .prose h2 {
            color: rgb(229 231 235);
        }
        
        .prose h3 {
            font-size: 1.5rem;
            line-height: 1.4;
            margin-top: 2.5rem;
            margin-bottom: 1.25rem;
            color: rgb(55 65 81);
        }
        .dark .prose h3 {
            color: rgb(209 213 219);
        }
        
        /* List improvements */
        .prose ul, .prose ol {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            padding-left: 1.75rem;
        }
        
        .prose li {
            margin-top: 0.75rem;
            margin-bottom: 0.75rem;
            line-height: 1.7;
        }
        
        .prose li::marker {
            color: rgb(59 130 246);
            font-weight: 600;
        }
        .dark .prose li::marker {
            color: rgb(96 165 250);
        }
        
        /* Code block improvements */
        .prose pre {
            position: relative;
            overflow-x: auto;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin: 2rem 0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            background-color: rgb(248 250 252) !important;
            border: 1px solid rgb(226 232 240);
        }
        
        .dark .prose pre {
            background-color: rgb(15 23 42) !important;
            border-color: rgb(51 65 85);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }
        
        .prose pre code {
            background: transparent !important;
            padding: 0 !important;
            border-radius: 0 !important;
            font-size: 0.875rem;
            line-height: 1.6;
            color: inherit !important;
        }
        
        /* Override highlight.js theme for better dark mode */
        .dark .prose pre code .hljs-keyword,
        .dark .prose pre code .hljs-selector-tag,
        .dark .prose pre code .hljs-built_in {
            color: rgb(96 165 250) !important;
        }
        
        .dark .prose pre code .hljs-string,
        .dark .prose pre code .hljs-attr {
            color: rgb(34 197 94) !important;
        }
        
        .dark .prose pre code .hljs-number,
        .dark .prose pre code .hljs-literal {
            color: rgb(251 146 60) !important;
        }
        
        .dark .prose pre code .hljs-comment {
            color: rgb(148 163 184) !important;
            font-style: italic;
        }
        
        .dark .prose pre code .hljs-title,
        .dark .prose pre code .hljs-function {
            color: rgb(236 72 153) !important;
        }
        
        /* Table improvements */
        .prose table {
            margin: 2rem 0;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .prose th {
            background: linear-gradient(135deg, rgb(59 130 246) 0%, rgb(37 99 235) 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.875rem;
        }
        
        .prose tbody tr:nth-child(even) {
            background-color: rgb(249 250 251);
        }
        .dark .prose tbody tr:nth-child(even) {
            background-color: rgb(31 41 55);
        }
        
        /* Blockquote enhancements */
        .prose blockquote {
            font-style: italic;
            position: relative;
            margin: 2rem 0;
        }
        
        .prose blockquote::before {
            content: '"';
            font-size: 4rem;
            position: absolute;
            left: -0.5rem;
            top: -1rem;
            color: rgb(59 130 246);
            opacity: 0.3;
            font-family: Georgia, serif;
        }
        
        /* Link improvements */
        .prose a {
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .prose a:hover {
            color: rgb(37 99 235);
            transform: translateY(-1px);
        }
        .dark .prose a:hover {
            color: rgb(147 197 253);
        }
        
        /* Image improvements */
        .prose img {
            margin: 2rem auto;
            max-width: 100%;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Copy button styling */
        .group:hover .copy-btn {
            opacity: 1;
        }
        
        .copy-btn {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            padding: 0.5rem 0.75rem;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            cursor: pointer;
            opacity: 0;
            transition: all 0.2s ease;
            z-index: 10;
        }
        
        .copy-btn:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: scale(1.05);
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configure marked for better rendering
            marked.setOptions({
                highlight: function(code, lang) {
                    if (lang && hljs.getLanguage(lang)) {
                        try {
                            return hljs.highlight(code, { language: lang }).value;
                        } catch (err) {}
                    }
                    return hljs.highlightAuto(code).value;
                },
                breaks: true,
                gfm: true,
            });

            // Convert markdown content to HTML for better rendering
            const contentElement = document.getElementById('blog-content');
            if (contentElement) {
                const rawContent = {!! json_encode($blog->getTranslation('content', app()->getLocale())) !!};
                
                // Check if content appears to be markdown
                if (rawContent && (rawContent.includes('#') || rawContent.includes('```') || rawContent.includes('*') || rawContent.includes('[') || rawContent.includes('|'))) {
                    contentElement.innerHTML = marked.parse(rawContent);
                }
            }
            
            // Function to update highlight.js theme based on current theme
            function updateHighlightTheme() {
                const isDark = document.documentElement.classList.contains('dark') || 
                              (localStorage.getItem('appearance') === 'dark') ||
                              (localStorage.getItem('appearance') === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                
                // Remove existing highlight.js stylesheets
                document.querySelectorAll('link[href*="highlight.js"]').forEach(link => link.remove());
                
                // Add appropriate theme
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = isDark 
                    ? 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github-dark.min.css'
                    : 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github.min.css';
                document.head.appendChild(link);
                
                // Re-highlight after theme change
                setTimeout(() => hljs.highlightAll(), 100);
            }
            
            // Initial theme setup and highlighting
            updateHighlightTheme();
            
            // Listen for theme changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        updateHighlightTheme();
                    }
                });
            });
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
            
            // Add copy buttons to code blocks
            function addCopyButtons() {
                document.querySelectorAll('pre code').forEach((block) => {
                    // Skip if copy button already exists
                    if (block.parentNode.querySelector('.copy-btn')) {
                        return;
                    }
                    
                    // Create copy button
                    const button = document.createElement('button');
                    button.className = 'copy-btn';
                    button.textContent = 'Copy';
                    
                    // Wrap pre in relative container
                    const pre = block.parentNode;
                    pre.style.position = 'relative';
                    pre.className += ' group';
                    pre.appendChild(button);
                    
                    // Add click handler
                    button.addEventListener('click', async () => {
                        try {
                            // Try modern clipboard API first
                            if (navigator.clipboard && window.isSecureContext) {
                                await navigator.clipboard.writeText(block.textContent);
                            } else {
                                // Fallback to legacy method
                                const textArea = document.createElement('textarea');
                                textArea.value = block.textContent;
                                textArea.style.position = 'fixed';
                                textArea.style.left = '-999999px';
                                textArea.style.top = '-999999px';
                                document.body.appendChild(textArea);
                                textArea.focus();
                                textArea.select();
                                
                                const successful = document.execCommand('copy');
                                document.body.removeChild(textArea);
                                
                                if (!successful) {
                                    throw new Error('execCommand failed');
                                }
                            }
                            
                            button.textContent = 'Copied!';
                            button.style.backgroundColor = 'rgba(34, 197, 94, 0.8)';
                            setTimeout(() => {
                                button.textContent = 'Copy';
                                button.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                            }, 2000);
                        } catch (err) {
                            console.error('Copy failed:', err);
                            button.textContent = 'Failed';
                            button.style.backgroundColor = 'rgba(239, 68, 68, 0.8)';
                            setTimeout(() => {
                                button.textContent = 'Copy';
                                button.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                            }, 2000);
                        }
                    });
                });
            }
            
            // Add copy buttons initially and after content changes
            addCopyButtons();
        });

        // Social sharing and clipboard functions
        function copyToClipboard(text) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(function() {
                    showCopyNotification('{{ __("messages.link_copied") }}', 'success');
                }, function(err) {
                    console.error('Could not copy text: ', err);
                    fallbackCopyToClipboard(text);
                });
            } else {
                fallbackCopyToClipboard(text);
            }
        }

        function fallbackCopyToClipboard(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            
            textArea.focus();
            textArea.select();
            
            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showCopyNotification('{{ __("messages.link_copied") }}', 'success');
                } else {
                    showCopyNotification('{{ __("messages.copy_failed") }}', 'error');
                }
            } catch (err) {
                console.error('Fallback copy failed: ', err);
                showCopyNotification('{{ __("messages.copy_not_supported") }}', 'error');
            }
            
            document.body.removeChild(textArea);
        }

        function showCopyNotification(message, type) {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            notification.className = `fixed top-4 right-4 ${bgColor} text-white px-4 py-2 rounded-md shadow-lg z-50 transition-opacity duration-300`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '1';
            }, 10);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
    </script>
    @endpush
</x-customer-frontend-layout::layout>