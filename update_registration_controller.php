<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'registration_number' => 'nullable|string|max:50',
            'home_diocese' => 'nullable|string|max:100',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'year_of_study' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile picture upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles'), $filename);
            $profilePicturePath = $filename;
        }

        // Create user with PENDING status by default
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'registration_number' => $request->registration_number,
            'home_diocese' => $request->home_diocese,
            'gender' => $request->gender,
            'year_of_study' => $request->year_of_study,
            'profile_picture' => $profilePicturePath,
            'membership_status' => 'Pending', // Default to Pending
            'role' => 'member', // Default role
        ]);

        // Log the user in automatically (optional - you may want to require admin approval first)
        // Auth::login($user);

        return redirect('/login')->with('success', 'Registration successful! Your account is pending admin approval. Please wait for admin to activate your account.');
    }
}
