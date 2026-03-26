<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the member dashboard
     */
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to access the dashboard.');
        }
        
        // Check if user has member role
        if (Auth::user()->role !== 'member') {
            Auth::logout();
            return redirect('/login')->with('error', 'Unauthorized access. Please login with correct credentials.');
        }
        
        return view('member.dashboard');
    }

    /**
     * Check if user session is valid
     */
    public function checkSession()
    {
        return response()->json([
            'authenticated' => Auth::check(),
            'user' => Auth::check() ? [
                'id' => Auth::id(),
                'name' => Auth::user()->name,
                'role' => Auth::user()->role
            ] : null
        ]);
    }
}
