<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if ($user->role !== $role) {
            // Redirect based on user's actual role
            switch ($user->role) {
                case 'admin':
                    return redirect('/admin/dashboard')->with('error', 'Access denied. Redirected to admin dashboard.');
                case 'leader':
                    return redirect('/leader/dashboard')->with('error', 'Access denied. Redirected to leader dashboard.');
                case 'member':
                    return redirect('/member/dashboard')->with('error', 'Access denied. Redirected to member dashboard.');
                default:
                    return redirect('/login')->with('error', 'Access denied. Invalid role.');
            }
        }

        return $next($request);
    }
}
