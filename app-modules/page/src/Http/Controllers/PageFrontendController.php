<?php

namespace Modules\Page\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Page\Models\Page;
use Illuminate\Http\Request;

class PageFrontendController extends Controller
{
    /**
     * Display the specified page on frontend.
     */
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
                   ->published()
                   ->firstOrFail();

        // If page has a template, use it
        if ($page->hasTemplate()) {
            return view($page->getTemplateView(), compact('page'));
        }

        // Otherwise use default page view
        return view('pages.default', compact('page'));
    }
}