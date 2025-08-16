<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Models\Blog;
use Modules\Blog\Models\Tag;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    /**
     * Display a listing of the blogs.
     */
    public function index()
    {
        $statuses = Blog::getAvailableStatuses();
        $tags = Tag::all();
        
        return view('blog::index', compact('statuses', 'tags'));
    }

    /**
     * Get blog data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $model = Blog::with('tags');

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Status filter
                if ($request->has('status') && $request->get('status')) {
                    $query->where('status', $request->get('status'));
                }
                
                // Tag filter
                if ($request->has('tag_id') && $request->get('tag_id')) {
                    $query->whereHas('tags', function ($q) use ($request) {
                        $q->where('id', $request->get('tag_id'));
                    });
                }
                
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('english_title', 'like', "%{$searchText}%")
                          ->orWhere('slug', 'like', "%{$searchText}%")
                          ->orWhere('title->en', 'like', "%{$searchText}%")
                          ->orWhere('title->bn', 'like', "%{$searchText}%")
                          ->orWhere('content->en', 'like', "%{$searchText}%")
                          ->orWhere('content->bn', 'like', "%{$searchText}%")
                          ->orWhere('excerpt->en', 'like', "%{$searchText}%")
                          ->orWhere('excerpt->bn', 'like', "%{$searchText}%");
                    });
                }
            }, true)
            ->addColumn('english_title_formatted', function (Blog $blog) {
                return '<div class="font-medium">' . htmlspecialchars($blog->english_title) . '</div>';
            })
            ->addColumn('slug_formatted', function (Blog $blog) {
                return '<code class="px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded text-sm">' . htmlspecialchars($blog->slug) . '</code>';
            })
            ->addColumn('status_badge', function (Blog $blog) {
                return $blog->status_badge;
            })
            ->addColumn('tags_formatted', function (Blog $blog) {
                if ($blog->tags->isEmpty()) {
                    return '<span class="text-sm text-gray-500">No tags</span>';
                }
                
                $tagHtml = '';
                foreach ($blog->tags->take(3) as $tag) {
                    $tagHtml .= '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 mr-1">' 
                              . htmlspecialchars($tag->name) . '</span>';
                }
                
                if ($blog->tags->count() > 3) {
                    $tagHtml .= '<span class="text-xs text-gray-500">+' . ($blog->tags->count() - 3) . ' more</span>';
                }
                
                return $tagHtml;
            })
            ->addColumn('excerpt_preview', function (Blog $blog) {
                $preview = strip_tags($blog->excerpt ?: $blog->content);
                $preview = trim($preview);
                if (strlen($preview) > 50) {
                    $preview = substr($preview, 0, 47) . '...';
                }
                return '<span class="text-sm text-gray-600 dark:text-gray-400">' . htmlspecialchars($preview) . '</span>';
            })
            ->addColumn('published_at_formatted', function (Blog $blog) {
                return $blog->published_at ? $blog->published_at->format('M d, Y H:i') : '-';
            })
            ->addColumn('created_at_formatted', function (Blog $blog) {
                return $blog->created_at->format('M d, Y H:i');
            })
            ->addColumn('action', function (Blog $blog) {
                $actions = '<div class="flex items-center space-x-2">';
                
                $actions .= '<a href="' . route('blog::admin.blog.show', $blog->slug) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors" title="View">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>';
                
                $actions .= '<a href="' . route('blog::admin.blog.edit', $blog->slug) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 transition-colors" title="Edit">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>';
                
                $actions .= '</div>';
                
                return $actions;
            })
            ->rawColumns(['english_title_formatted', 'slug_formatted', 'status_badge', 'tags_formatted', 'excerpt_preview', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating new blog.
     */
    public function create()
    {
        $statuses = Blog::getAvailableStatuses();
        $tags = Tag::all();
        
        return view('blog::create', compact('statuses', 'tags'));
    }

    /**
     * Store a newly created blog.
     */
    public function store(Request $request)
    {
        $request->validate([
            'english_title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'title.en' => 'required|string|max:255',
            'title.bn' => 'nullable|string|max:255',
            'content.en' => 'required|string',
            'content.bn' => 'nullable|string',
            'excerpt.en' => 'nullable|string|max:500',
            'excerpt.bn' => 'nullable|string|max:500',
            'meta_title.en' => 'nullable|string|max:60',
            'meta_title.bn' => 'nullable|string|max:60',
            'meta_description.en' => 'nullable|string|max:160',
            'meta_description.bn' => 'nullable|string|max:160',
            'meta_keywords.en' => 'nullable|string|max:255',
            'meta_keywords.bn' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url|max:255',
            'noindex' => 'nullable|boolean',
            'nofollow' => 'nullable|boolean',
            'status' => 'required|in:draft,published,scheduled',
            'featured_image' => 'nullable|file|image|max:2048',
            'published_at' => 'nullable|date',
            'position' => 'nullable|integer|min:0',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        $blog = Blog::create([
            'english_title' => $request->english_title,
            'slug' => $request->slug ?: \Str::slug($request->english_title),
            'title' => [
                'en' => $request->input('title.en'),
                'bn' => $request->input('title.bn'),
            ],
            'content' => [
                'en' => $request->input('content.en'),
                'bn' => $request->input('content.bn'),
            ],
            'excerpt' => [
                'en' => $request->input('excerpt.en'),
                'bn' => $request->input('excerpt.bn'),
            ],
            'meta_title' => [
                'en' => $request->input('meta_title.en'),
                'bn' => $request->input('meta_title.bn'),
            ],
            'meta_description' => [
                'en' => $request->input('meta_description.en'),
                'bn' => $request->input('meta_description.bn'),
            ],
            'meta_keywords' => [
                'en' => $request->input('meta_keywords.en'),
                'bn' => $request->input('meta_keywords.bn'),
            ],
            'canonical_url' => $request->canonical_url,
            'noindex' => $request->boolean('noindex'),
            'nofollow' => $request->boolean('nofollow'),
            'status' => $request->status,
            'published_at' => $request->published_at,
            'position' => $request->position ?? 0,
            'user_id' => auth()->id(),
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $blog->addMediaFromRequest('featured_image')
                 ->toMediaCollection('featured_image');
        }

        if ($request->has('tags')) {
            $blog->syncTags(Tag::whereIn('id', $request->tags)->pluck('english_name')->toArray());
        }

        return redirect()->route('blog::admin.blog.index')
                       ->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified blog.
     */
    public function show(Blog $blog)
    {
        $blog->load('tags');
        return view('blog::show', compact('blog'));
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit(Blog $blog)
    {
        $statuses = Blog::getAvailableStatuses();
        $tags = Tag::all();
        $blog->load('tags');
        
        return view('blog::edit', compact('blog', 'statuses', 'tags'));
    }

    /**
     * Update the specified blog.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'english_title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'title.en' => 'required|string|max:255',
            'title.bn' => 'nullable|string|max:255',
            'content.en' => 'required|string',
            'content.bn' => 'nullable|string',
            'excerpt.en' => 'nullable|string|max:500',
            'excerpt.bn' => 'nullable|string|max:500',
            'meta_title.en' => 'nullable|string|max:60',
            'meta_title.bn' => 'nullable|string|max:60',
            'meta_description.en' => 'nullable|string|max:160',
            'meta_description.bn' => 'nullable|string|max:160',
            'meta_keywords.en' => 'nullable|string|max:255',
            'meta_keywords.bn' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|url|max:255',
            'noindex' => 'nullable|boolean',
            'nofollow' => 'nullable|boolean',
            'status' => 'required|in:draft,published,scheduled',
            'featured_image' => 'nullable|file|image|max:2048',
            'published_at' => 'nullable|date',
            'position' => 'nullable|integer|min:0',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        $blog->update([
            'english_title' => $request->english_title,
            'slug' => $request->slug ?: \Str::slug($request->english_title),
            'title' => [
                'en' => $request->input('title.en'),
                'bn' => $request->input('title.bn'),
            ],
            'content' => [
                'en' => $request->input('content.en'),
                'bn' => $request->input('content.bn'),
            ],
            'excerpt' => [
                'en' => $request->input('excerpt.en'),
                'bn' => $request->input('excerpt.bn'),
            ],
            'meta_title' => [
                'en' => $request->input('meta_title.en'),
                'bn' => $request->input('meta_title.bn'),
            ],
            'meta_description' => [
                'en' => $request->input('meta_description.en'),
                'bn' => $request->input('meta_description.bn'),
            ],
            'meta_keywords' => [
                'en' => $request->input('meta_keywords.en'),
                'bn' => $request->input('meta_keywords.bn'),
            ],
            'canonical_url' => $request->canonical_url,
            'noindex' => $request->boolean('noindex'),
            'nofollow' => $request->boolean('nofollow'),
            'status' => $request->status,
            'published_at' => $request->published_at,
            'position' => $request->position ?? 0,
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Clear existing featured image
            $blog->clearMediaCollection('featured_image');
            
            // Add new featured image
            $blog->addMediaFromRequest('featured_image')
                 ->toMediaCollection('featured_image');
        }

        if ($request->has('tags')) {
            $blog->syncTags(Tag::whereIn('id', $request->tags)->pluck('english_name')->toArray());
        } else {
            $blog->syncTags([]);
        }

        return redirect()->route('blog::admin.blog.show', $blog->slug)
                       ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog.
     */
    public function destroy(Blog $blog)
    {
        try {
            $blog->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Blog post deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}