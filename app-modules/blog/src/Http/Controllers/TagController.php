<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Models\Tag;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    /**
     * Display a listing of the tags.
     */
    public function index()
    {
        $tags = Tag::withCount('blogs')->orderBy('created_at', 'desc')->paginate(10);
        return view('blog::tags.index', compact('tags'));
    }

    /**
     * Get tag data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $model = Tag::withCount('blogs');

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('english_name', 'like', "%{$searchText}%")
                          ->orWhere('name->en', 'like', "%{$searchText}%")
                          ->orWhere('name->bn', 'like', "%{$searchText}%")
                          ->orWhere('slug', 'like', "%{$searchText}%");
                    });
                }
            }, true)
            ->addColumn('name_formatted', function (Tag $tag) {
                return '<div class="font-medium">' . htmlspecialchars($tag->name) . '</div>';
            })
            ->addColumn('slug_formatted', function (Tag $tag) {
                return '<code class="px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded text-sm">' . htmlspecialchars($tag->slug) . '</code>';
            })
            ->addColumn('usage_count', function (Tag $tag) {
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">' 
                       . $tag->blogs_count . ' posts</span>';
            })
            ->addColumn('created_at_formatted', function (Tag $tag) {
                return $tag->created_at->format('M d, Y H:i');
            })
            ->addColumn('action', function (Tag $tag) {
                $actions = '<div class="flex items-center space-x-2">';
                
                $actions .= '<a href="' . route('blog::admin.tags.show', $tag->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors" title="View">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>';
                
                $actions .= '<a href="' . route('blog::admin.tags.edit', $tag->id) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 transition-colors" title="Edit">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>';
                
                $actions .= '</div>';
                
                return $actions;
            })
            ->rawColumns(['name_formatted', 'slug_formatted', 'usage_count', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating new tag.
     */
    public function create()
    {
        return view('blog::tags.create');
    }

    /**
     * Store a newly created tag.
     */
    public function store(Request $request)
    {
        $request->validate([
            'english_name' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'name.bn' => 'nullable|string|max:255',
        ]);

        $slug = \Str::slug($request->english_name);
        
        // Ensure slug is unique
        $originalSlug = $slug;
        $counter = 1;
        while (Tag::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $tag = Tag::create([
            'english_name' => $request->english_name,
            'slug' => $slug,
            'name' => [
                'en' => $request->input('name.en'),
                'bn' => $request->input('name.bn'),
            ],
        ]);

        return redirect()->route('blog::admin.tags.show', $tag->slug)
                       ->with('success', 'Tag created successfully!');
    }

    /**
     * Display the specified tag.
     */
    public function show($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $tag->loadCount('blogs');
        return view('blog::tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified tag.
     */
    public function edit($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        return view('blog::tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag.
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'english_name' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'name.bn' => 'nullable|string|max:255',
        ]);

        $tag = Tag::where('slug', $slug)->firstOrFail();
        
        $newSlug = \Str::slug($request->english_name);
        
        // Ensure slug is unique (excluding current tag)
        $originalSlug = $newSlug;
        $counter = 1;
        while (Tag::where('slug', $newSlug)->where('id', '!=', $tag->id)->exists()) {
            $newSlug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $tag->update([
            'english_name' => $request->english_name,
            'slug' => $newSlug,
            'name' => [
                'en' => $request->input('name.en'),
                'bn' => $request->input('name.bn'),
            ],
        ]);

        return redirect()->route('blog::admin.tags.show', $tag->slug)
                       ->with('success', 'Tag updated successfully!');
    }

    /**
     * Remove the specified tag.
     */
    public function destroy($slug)
    {
        try {
            $tag = Tag::where('slug', $slug)->firstOrFail();
            $tag->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Tag deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}