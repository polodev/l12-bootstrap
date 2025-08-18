<?php

namespace Modules\CustomerDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Subscription\Models\UserSubscription;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('customer-dashboard::accounts.index', compact('user'));
    }

    public function orders()
    {
        $user = auth()->user();
        // TODO: Add orders functionality later
        return view('customer-dashboard::accounts.orders', compact('user'));
    }

    public function wishlist()
    {
        $user = auth()->user();
        // TODO: Add wishlist functionality later
        return view('customer-dashboard::accounts.wishlist', compact('user'));
    }

    public function support()
    {
        $user = auth()->user();
        // TODO: Add support functionality later
        return view('customer-dashboard::accounts.support', compact('user'));
    }

    public function subscription()
    {
        $user = auth()->user();
        
        // Get current subscription
        $currentSubscription = UserSubscription::forUser($user->id)
            ->with(['subscriptionPlan', 'payment'])
            ->latest()
            ->first();
            
        // Get subscription history
        $subscriptionHistory = UserSubscription::forUser($user->id)
            ->with(['subscriptionPlan', 'payment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('customer-dashboard::accounts.subscription', compact('user', 'currentSubscription', 'subscriptionHistory'));
    }
}