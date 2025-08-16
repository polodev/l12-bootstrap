<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Models\Blog;
use Modules\Blog\Models\Tag;

class BlogFrontendController extends Controller
{
    /**
     * Display a listing of published blogs.
     */
    public function index()
    {
        $blogs = Blog::published()
            ->with('tags')
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $tags = Tag::withCount('blogs')
            ->having('blogs_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('blog::frontend.index', compact('blogs', 'tags'));
    }

    /**
     * Display the specified blog post.
     */
    public function show(Blog $blog)
    {
        // Check if blog is published and live
        if (!$blog->isLive()) {
            abort(404);
        }

        $blog->load('tags');

        // Get related posts
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->when($blog->tags->isNotEmpty(), function ($query) use ($blog) {
                $query->whereHas('tags', function ($q) use ($blog) {
                    $q->whereIn('tags.english_name', $blog->tags->pluck('english_name'));
                });
            })
            ->with('tags')
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        return view('blog::frontend.show', compact('blog', 'relatedBlogs'));
    }

    /**
     * Display blogs by tag.
     */
    public function blogsByTag(Tag $tag)
    {
        $blogs = Blog::published()
            ->whereHas('tags', function ($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->with('tags')
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $allTags = Tag::withCount('blogs')
            ->having('blogs_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('blog::frontend.index', compact('blogs', 'allTags', 'tag'));
    }

    /**
     * Display all blog tags.
     */
    public function tags()
    {
        $tags = Tag::withCount(['blogs' => function ($query) {
                $query->where('status', 'published')
                      ->whereNotNull('published_at')
                      ->where('published_at', '<=', now());
            }])
            ->having('blogs_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('blog::frontend.tags', compact('tags'));
    }

    /**
     * Display tag details with blogs.
     */
    public function tagShow($slug)
    {
        // Find tag by slug
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $blogs = Blog::published()
            ->whereHas('tags', function ($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->with('tags')
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('blog::frontend.tag-show', compact('tag', 'blogs'));
    }
}