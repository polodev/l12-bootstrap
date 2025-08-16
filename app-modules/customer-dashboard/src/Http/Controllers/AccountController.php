<?php

namespace Modules\CustomerDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('customer-dashboard::account.index', compact('user'));
    }

    public function orders()
    {
        $user = auth()->user();
        // TODO: Add orders functionality later
        return view('customer-dashboard::account.orders', compact('user'));
    }

    public function wishlist()
    {
        $user = auth()->user();
        // TODO: Add wishlist functionality later
        return view('customer-dashboard::account.wishlist', compact('user'));
    }

    public function support()
    {
        $user = auth()->user();
        // TODO: Add support functionality later
        return view('customer-dashboard::account.support', compact('user'));
    }
}