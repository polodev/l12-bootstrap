<?php

namespace Modules\AdminDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'unverified_users' => User::whereNull('email_verified_at')->count(),
            'users_this_month' => User::whereMonth('created_at', now()->month)
                                     ->whereYear('created_at', now()->year)
                                     ->count(),
            'users_today' => User::whereDate('created_at', today())->count(),
        ];

        // Get role statistics
        $roleStats = User::all()
            ->groupBy(function($user) {
                return $user->role ?? 'No Role';
            })
            ->map(function($users) {
                return $users->count();
            });

        // Recent users
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin-dashboard::dashboard.index', compact('stats', 'roleStats', 'recentUsers'));
    }
}