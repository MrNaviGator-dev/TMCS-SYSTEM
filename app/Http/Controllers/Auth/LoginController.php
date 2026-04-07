<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'password' => 'required|min:6',
        ], [
            'phone_number.required' => 'Please enter your phone number',
        ]);

        $phoneNumber = $request->phone_number;
        $password = $request->password;
        $remember = $request->has('remember');

        try {
            // Find user by phone number
            $user = User::where('phone_number', $phoneNumber)->first();
            
            if (!$user) {
                \Log::warning("Login failed: User not found with Username: {$phoneNumber}");
                return back()->with('error', 'Invalid Username or password')->withInput();
            }

            // Check password
            if (!Hash::check($password, $user->password)) {
                \Log::warning("Login failed: Invalid password for Username: {$phoneNumber}");
                return back()->with('error', 'Invalid Username or password')->withInput();
            }

            // Check if user is approved (membership_status must be 'Active')
            $userStatus = $user->membership_status ?? 'Active';
            if ($userStatus !== 'Active') {
                \Log::warning("Login failed: User not approved. Phone: {$phoneNumber}, Status: {$userStatus}");
                return back()->with('error', 'Your account is not yet approved. Please wait for admin approval.')->withInput();
            }

            // Log the user in
            Auth::login($user, $remember);

            // Log successful login
            \Log::info("User logged in successfully: {$user->email} (Role: {$user->role}, Phone: {$phoneNumber})");

            // Redirect based on user role
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard')->with('success', 'Welcome back, Admin!');
                case 'leader':
                    return redirect()->intended('/leader/dashboard')->with('success', 'Welcome back, Leader!');
                case 'member':
                default:
                    return redirect()->intended('/member/dashboard')->with('success', 'Welcome back, Member!');
            }

        } catch (\Exception $e) {
            \Log::error('Login error: ' . $e->getMessage());
            return back()->with('error', 'Login failed. Please try again.')->withInput();
        }
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        try {
            $user = Auth::user();
            
            if ($user) {
                \Log::info("User logged out: {$user->email} (Role: {$user->role})");
            }

            Auth::logout();
            
            // Invalidate session
            $request->session()->invalidate();
            
            // Regenerate CSRF token
            $request->session()->regenerateToken();

            return redirect('/');

        } catch (\Exception $e) {
            \Log::error('Logout error: ' . $e->getMessage());
            return redirect('/')->with('error', 'Logout failed. Please try again.');
        }
    }

    /**
     * Show dashboard based on user role
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect('/')->with('error', 'Please login first.');
        }

        switch ($user->role) {
            case 'admin':
                return view('admin.dashboard', compact('user'));
            case 'leader':
                return view('leader.dashboard', compact('user'));
            case 'member':
            default:
                return view('member.dashboard', compact('user'));
        }
    }
}
