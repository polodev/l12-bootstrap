<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3">
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $documentation->title }}</h1>
                        @if($documentation->difficulty)
                            {!! $documentation->difficulty_badge !!}
                        @endif
                        @if($documentation->is_published)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">Published</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100">Draft</span>
                        @endif
                    </div>
                    
                    <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600 dark:text-gray-400">
                        @if($documentation->section)
                            @php
                                $sections = \Modules\Documentation\Models\WebsiteDocumentation::getAvailableSections();
                                $sectionName = $sections[$documentation->section] ?? ucfirst($documentation->section);
                            @endphp
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                {{ $sectionName }}
                            </span>
                        @endif
                        
                        @if($documentation->position)
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                Position: {{ $documentation->position }}
                            </span>
                        @endif
                        
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 10h6a2 2 0 002-2V7H6v8a2 2 0 002 2z"></path>
                            </svg>
                            Created: {{ $documentation->created_at->format('M d, Y') }}
                        </span>
                        
                        @if($documentation->updated_at != $documentation->created_at)
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Updated: {{ $documentation->updated_at->format('M d, Y') }}
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="flex items-center space-x-2">
                    <a href="{{ route('documentation::admin.edit', $documentation->slug) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('documentation::admin.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="p-8">
            <article class="prose prose-base sm:prose-lg max-w-none dark:prose-invert prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-gray-100 prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-p:leading-relaxed prose-li:text-gray-700 dark:prose-li:text-gray-300 prose-strong:text-gray-900 dark:prose-strong:text-gray-100 prose-code:text-red-600 dark:prose-code:text-red-400 prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:text-sm prose-pre:bg-gray-50 dark:prose-pre:bg-gray-900 prose-pre:border prose-pre:border-gray-200 dark:prose-pre:border-gray-700 prose-blockquote:border-l-4 prose-blockquote:border-blue-500 prose-blockquote:bg-blue-50 dark:prose-blockquote:bg-blue-900/20 prose-blockquote:pl-6 prose-blockquote:py-4 prose-blockquote:rounded-r prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline prose-img:rounded-lg prose-img:shadow-lg" id="documentation-content">
                {!! $documentation->formatted_content !!}
            </article>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github.min.css" media="(prefers-color-scheme: light)">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github-dark.min.css" media="(prefers-color-scheme: dark)">
    <style>
        /* Enhanced prose styles for beautiful documentation */
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
        
        /* Step headings enhancement */
        .prose h2:contains("Step"), .prose h3:contains("Step") {
            background: linear-gradient(135deg, rgb(59 130 246) 0%, rgb(37 99 235) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
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

            // Convert markdown content to HTML if needed
            const contentElement = document.getElementById('documentation-content');
            const rawContent = {!! json_encode($documentation->content) !!};
            
            // Check if content appears to be markdown
            if (rawContent.includes('#') || rawContent.includes('```') || rawContent.includes('*') || rawContent.includes('[') || rawContent.includes('|')) {
                contentElement.innerHTML = marked.parse(rawContent);
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
            document.querySelectorAll('pre code').forEach((block) => {
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
        });
    </script>
    @endpush
</x-admin-dashboard-layout::layout>