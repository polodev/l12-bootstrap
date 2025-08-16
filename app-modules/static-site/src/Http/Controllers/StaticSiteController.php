<?php

namespace Modules\StaticSite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class StaticSiteController extends Controller
{
    public function about()
    {
        return view('static-site::about.about');
    }
}