<x-admin-dashboard-layout::layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Tag Details</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">View tag information and associated blog posts</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('blog::admin.tags.edit', $tag->slug) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Tag
                    </a>
                    <form method="POST" action="{{ route('blog::admin.tags.destroy', $tag->slug) }}" class="inline-block" 
                          onsubmit="return confirm('Are you sure you want to delete this tag? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Tag
                        </button>
                    </form>
                    <a href="{{ route('blog::admin.tags.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Tags
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Tag Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Tag Information</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">English Name</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tag->english_name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Display Name (English)</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tag->getTranslation('name', 'en') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Display Name (Bengali)</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tag->getTranslation('name', 'bn') ?: 'Not set' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slug</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $tag->slug }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">Statistics</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Blog Posts</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                    {{ $tag->blogs_count }} posts
                                </span>
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Created</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tag->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Updated</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $tag->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Associated Blog Posts -->
            @if($tag->blogs_count > 0)
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">Associated Blog Posts ({{ $tag->blogs_count }})</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($tag->blogs()->latest()->limit(10)->get() as $blog)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $blog->getTranslation('title', 'en') }}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Status: 
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                @if($blog->status === 'published') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                @elseif($blog->status === 'draft') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                @else bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 @endif">
                                                {{ ucfirst($blog->status) }}
                                            </span>
                                            | Created: {{ $blog->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('blog::admin.blog.show', $blog->slug) }}" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                            View
                                        </a>
                                        <a href="{{ route('blog::admin.blog.edit', $blog->slug) }}" class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-700 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if($tag->blogs_count > 10)
                                <div class="text-center pt-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Showing 10 of {{ $tag->blogs_count }} blog posts
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No blog posts</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">This tag hasn't been used in any blog posts yet.</p>
                </div>
            @endif
        </div>
    </div>
</x-admin-dashboard-layout::layout>