<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
   
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if (!Auth::check()) {
    //         Log::warning('User not authenticated, redirecting to login');
    //         return redirect()->route('admin.login')->with('error', 'Please login first');
    //     }

    //     if (Auth::user()->is_admin != 1) {
    //         Log::warning('User is not admin', [
    //             'user_id' => Auth::id(),
    //             'is_admin' => Auth::user()->is_admin
    //         ]);
    //         Auth::logout();
    //         return redirect()->route('admin.login')->with('error', 'Unauthorized access');
    //     }

    //     Log::info('AdminMiddleware passed, user is admin');
    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            Log::warning('User not authenticated, redirecting to login');
            return redirect()->route('admin.login')->with('error', 'Please login first');
        }

        $user = Auth::user();
        $user->load('role');
        
        // Define allowed admin roles
        $adminRoles = ['super-admin', 'counselor', 'college-admin'];
        
        // Check only role (remove is_admin dependency)
        if (!$user->role || !in_array($user->role->slug, $adminRoles)) {
            Log::warning('User is not authorized as admin', [
                'user_id' => $user->id,
                'role_slug' => $user->role ? $user->role->slug : 'none'
            ]);
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Unauthorized access');
        }

        Log::info('AdminMiddleware passed', [
            'user_id' => $user->id,
            'role' => $user->role->slug
        ]);
        return $next($request);
    }
}
