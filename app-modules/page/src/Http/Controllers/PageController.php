<?php

namespace Modules\Page\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Page\Models\Page;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    /**
     * Display a listing of the pages.
     */
    public function index()
    {
        $pages = Page::orderBy('created_at', 'desc')->paginate(10);
        return view('page::pages.index', compact('pages'));
    }

    /**
     * Get page data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $model = Page::query();

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('english_title', 'like', "%{$searchText}%")
                          ->orWhere('title->en', 'like', "%{$searchText}%")
                          ->orWhere('title->bn', 'like', "%{$searchText}%")
                          ->orWhere('slug', 'like', "%{$searchText}%");
                    });
                }
            }, true)
            ->addColumn('english_title_formatted', function (Page $page) {
                return '<div class="font-medium">' . htmlspecialchars($page->english_title) . '</div>';
            })
            ->addColumn('slug_formatted', function (Page $page) {
                return '<code class="px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded text-sm">' . htmlspecialchars($page->slug) . '</code>';
            })
            ->addColumn('template_formatted', function (Page $page) {
                if (!$page->template || $page->template === 'default') {
                    return '<span class="text-gray-500 dark:text-gray-400">Default</span>';
                }
                return '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">' 
                       . htmlspecialchars($page->template) . '</span>';
            })
            ->addColumn('status_badge', function (Page $page) {
                return $page->status_badge;
            })
            ->addColumn('published_at_formatted', function (Page $page) {
                return $page->published_at ? $page->published_at->format('M d, Y H:i') : '-';
            })
            ->addColumn('created_at_formatted', function (Page $page) {
                return $page->created_at->format('M d, Y H:i');
            })
            ->addColumn('action', function (Page $page) {
                $actions = '<div class="flex items-center space-x-2">';
                
                $actions .= '<a href="' . route('page::admin.pages.show', $page->slug) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors" title="View">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>';
                
                $actions .= '<a href="' . route('page::admin.pages.edit', $page->slug) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 transition-colors" title="Edit">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>';
                
                $actions .= '</div>';
                
                return $actions;
            })
            ->rawColumns(['english_title_formatted', 'slug_formatted', 'template_formatted', 'status_badge', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating new page.
     */
    public function create()
    {
        $statuses = Page::getAvailableStatuses();
        $templates = Page::getAvailableTemplates();
        
        return view('page::pages.create', compact('statuses', 'templates'));
    }

    /**
     * Store a newly created page.
     */
    public function store(Request $request)
    {
        $request->validate([
            'english_title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'title.en' => 'required|string|max:255',
            'title.bn' => 'nullable|string|max:255',
            'content.en' => 'required|string',
            'content.bn' => 'nullable|string',
            'template' => 'nullable|string|max:255',
            'meta_title.en' => 'nullable|string|max:60',
            'meta_title.bn' => 'nullable|string|max:60',
            'meta_description.en' => 'nullable|string|max:160',
            'meta_description.bn' => 'nullable|string|max:160',
            'keywords.en' => 'nullable|string|max:255',
            'keywords.bn' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'position' => 'nullable|integer|min:0',
        ]);

        $page = Page::create([
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
            'template' => $request->template === 'default' ? null : $request->template,
            'meta_title' => [
                'en' => $request->input('meta_title.en'),
                'bn' => $request->input('meta_title.bn'),
            ],
            'meta_description' => [
                'en' => $request->input('meta_description.en'),
                'bn' => $request->input('meta_description.bn'),
            ],
            'keywords' => [
                'en' => $request->input('keywords.en'),
                'bn' => $request->input('keywords.bn'),
            ],
            'status' => $request->status,
            'published_at' => $request->published_at,
            'position' => $request->position ?? 0,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('page::admin.pages.show', $page->slug)
                       ->with('success', 'Page created successfully!');
    }

    /**
     * Display the specified page.
     */
    public function show(Page $page)
    {
        return view('page::pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(Page $page)
    {
        $statuses = Page::getAvailableStatuses();
        $templates = Page::getAvailableTemplates();
        
        return view('page::pages.edit', compact('page', 'statuses', 'templates'));
    }

    /**
     * Update the specified page.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'english_title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'title.en' => 'required|string|max:255',
            'title.bn' => 'nullable|string|max:255',
            'content.en' => 'required|string',
            'content.bn' => 'nullable|string',
            'template' => 'nullable|string|max:255',
            'meta_title.en' => 'nullable|string|max:60',
            'meta_title.bn' => 'nullable|string|max:60',
            'meta_description.en' => 'nullable|string|max:160',
            'meta_description.bn' => 'nullable|string|max:160',
            'keywords.en' => 'nullable|string|max:255',
            'keywords.bn' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'position' => 'nullable|integer|min:0',
        ]);

        $page->update([
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
            'template' => $request->template === 'default' ? null : $request->template,
            'meta_title' => [
                'en' => $request->input('meta_title.en'),
                'bn' => $request->input('meta_title.bn'),
            ],
            'meta_description' => [
                'en' => $request->input('meta_description.en'),
                'bn' => $request->input('meta_description.bn'),
            ],
            'keywords' => [
                'en' => $request->input('keywords.en'),
                'bn' => $request->input('keywords.bn'),
            ],
            'status' => $request->status,
            'published_at' => $request->published_at,
            'position' => $request->position ?? 0,
        ]);

        return redirect()->route('page::admin.pages.show', $page->slug)
                       ->with('success', 'Page updated successfully!');
    }

    /**
     * Remove the specified page.
     */
    public function destroy(Page $page)
    {
        try {
            $page->delete();
            
            return redirect()->route('page::admin.pages.index')
                           ->with('success', 'Page deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to delete page. Please try again.');
        }
    }
}