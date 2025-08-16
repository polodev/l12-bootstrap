<?php

namespace Modules\Documentation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Documentation\Models\WebsiteDocumentation;
use Yajra\DataTables\Facades\DataTables;

class DocumentationController extends Controller
{
    /**
     * Display a listing of the documentation.
     */
    public function index()
    {
        $sections = WebsiteDocumentation::getAvailableSections();
        $difficulties = WebsiteDocumentation::getAvailableDifficulties();
        
        return view('documentation::index', compact('sections', 'difficulties'));
    }

    /**
     * Get documentation data for DataTables.
     */
    public function indexJson(Request $request)
    {
        $model = WebsiteDocumentation::query();

        return DataTables::eloquent($model)
            ->filter(function ($query) use ($request) {
                // Section filter
                if ($request->has('section') && $request->get('section')) {
                    $query->where('section', $request->get('section'));
                }
                
                // Difficulty filter
                if ($request->has('difficulty') && $request->get('difficulty')) {
                    $query->where('difficulty', $request->get('difficulty'));
                }
                
                // Published filter
                if ($request->has('is_published') && $request->get('is_published') !== '' && $request->get('is_published') !== null) {
                    $query->where('is_published', (bool) $request->get('is_published'));
                }
                
                // Search text filter
                if ($request->has('search_text') && $request->get('search_text')) {
                    $searchText = $request->get('search_text');
                    $query->where(function ($q) use ($searchText) {
                        $q->where('title', 'like', "%{$searchText}%")
                          ->orWhere('content', 'like', "%{$searchText}%")
                          ->orWhere('section', 'like', "%{$searchText}%");
                    });
                }
            }, true)
            ->addColumn('section_formatted', function (WebsiteDocumentation $doc) {
                $sections = WebsiteDocumentation::getAvailableSections();
                $sectionName = $sections[$doc->section] ?? ucfirst($doc->section);
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">' 
                       . $sectionName . '</span>';
            })
            ->addColumn('difficulty_badge', function (WebsiteDocumentation $doc) {
                return $doc->difficulty_badge;
            })
            ->addColumn('status_badge', function (WebsiteDocumentation $doc) {
                if ($doc->is_published) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">Published</span>';
                } else {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100">Draft</span>';
                }
            })
            ->addColumn('content_preview', function (WebsiteDocumentation $doc) {
                $preview = strip_tags($doc->content);
                $preview = trim($preview);
                if (strlen($preview) > 50) {
                    $preview = substr($preview, 0, 47) . '...';
                }
                return '<span class="text-sm text-gray-600 dark:text-gray-400">' . htmlspecialchars($preview) . '</span>';
            })
            ->addColumn('created_at_formatted', function (WebsiteDocumentation $doc) {
                return $doc->created_at->format('M d, Y H:i');
            })
            ->addColumn('action', function (WebsiteDocumentation $doc) {
                $actions = '<div class="flex items-center space-x-2">';
                
                $actions .= '<a href="' . route('documentation::admin.show', $doc->slug) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors" title="View">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>';
                
                $actions .= '<a href="' . route('documentation::admin.edit', $doc->slug) . '" class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium rounded text-white bg-yellow-600 hover:bg-yellow-700 transition-colors" title="Edit">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>';
                
                $actions .= '</div>';
                
                return $actions;
            })
            ->rawColumns(['section_formatted', 'difficulty_badge', 'status_badge', 'content_preview', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating new documentation.
     */
    public function create()
    {
        $sections = WebsiteDocumentation::getAvailableSections();
        $difficulties = WebsiteDocumentation::getAvailableDifficulties();
        
        return view('documentation::create', compact('sections', 'difficulties'));
    }

    /**
     * Store a newly created documentation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'difficulty' => 'nullable|in:beginner,intermediate,advanced',
            'position' => 'nullable|integer|min:0',
            'is_published' => 'boolean'
        ]);

        WebsiteDocumentation::create([
            'section' => $request->section,
            'title' => $request->title,
            'content' => $request->content,
            'difficulty' => $request->difficulty,
            'position' => $request->position ?? 0,
            'is_published' => $request->boolean('is_published', true),
            'user_id' => auth()->id()
        ]);

        return redirect()->route('documentation::admin.index')
                       ->with('success', 'Documentation created successfully!');
    }

    /**
     * Display the specified documentation.
     */
    public function show(WebsiteDocumentation $documentation)
    {
        return view('documentation::show', compact('documentation'));
    }

    /**
     * Show the form for editing the specified documentation.
     */
    public function edit(WebsiteDocumentation $documentation)
    {
        $sections = WebsiteDocumentation::getAvailableSections();
        $difficulties = WebsiteDocumentation::getAvailableDifficulties();
        
        return view('documentation::edit', compact('documentation', 'sections', 'difficulties'));
    }

    /**
     * Update the specified documentation.
     */
    public function update(Request $request, WebsiteDocumentation $documentation)
    {
        $request->validate([
            'section' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'difficulty' => 'nullable|in:beginner,intermediate,advanced',
            'position' => 'nullable|integer|min:0',
            'is_published' => 'boolean'
        ]);

        $documentation->update([
            'section' => $request->section,
            'title' => $request->title,
            'content' => $request->content,
            'difficulty' => $request->difficulty,
            'position' => $request->position ?? 0,
            'is_published' => $request->boolean('is_published', true)
        ]);

        return redirect()->route('documentation::admin.index')
                       ->with('success', 'Documentation updated successfully!');
    }

    /**
     * Remove the specified documentation.
     */
    public function destroy(WebsiteDocumentation $documentation)
    {
        try {
            $documentation->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Documentation deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}