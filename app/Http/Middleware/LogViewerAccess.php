<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogViewerAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // In local environment, allow anyone to access
        if (app()->environment('local')) {
            return $next($request);
        }

        // In production, require authentication and specific admin email
        if (!Auth::check()) {
            abort(403, 'Access denied. Authentication required.');
        }

        $adminEmail = env('ADMIN_USER_EMAIL', 'polodev10@gmail.com');
        
        if (Auth::user()->email !== $adminEmail) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}