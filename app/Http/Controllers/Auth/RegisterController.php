<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Debug: Check all request data including files
        \Log::info('=== NEW REGISTRATION ATTEMPT ===');
        \Log::info('All request data:', $request->all());
        \Log::info('Request files:', $request->allFiles());
        \Log::info('Has profile_picture: ' . ($request->hasFile('profile_picture') ? 'true' : 'false'));
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'registration_number' => 'nullable|string|unique:users',
            'home_diocese' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:users|regex:/^255[67]\d{8}$/',
            'gender' => 'required|in:Male,Female,Other',
            'year_of_study' => 'nullable|in:Year 1,Year 2,Year 3,Year 4,Year 5,Graduate,Staff',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|min:6|confirmed',
        ], [
            'phone_number.regex' => 'Phone number must start with 255 followed by 7 or 6 and 8 digits (e.g., 255716294829)',
            'gender.required' => 'Please select your gender',
            'gender.in' => 'Please select a valid gender option',
            'year_of_study.in' => 'Please select a valid year of study',
        ]);

        \Log::info('Validation passed!');

        try {
            // Debug: Check if gender and year_of_study are coming through
            \Log::info('=== NEW REGISTRATION ATTEMPT ===');
            \Log::info('Registration data received:', [
                'gender' => $request->gender,
                'year_of_study' => $request->year_of_study,
                'all_data' => $request->all()
            ]);

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'registration_number' => $request->registration_number,
                'home_diocese' => $request->home_diocese,
                'gender' => $request->gender,
                'year_of_study' => $request->year_of_study,
                'role' => 'member',
                'membership_status' => 'Pending', // New users start as Pending
                'password' => Hash::make($request->password),
            ];

            // Debug: Check what's in userData array
            \Log::info('User data array:', $userData);

            // Handle profile picture upload
            \Log::info('Checking for profile picture upload...');
            if ($request->hasFile('profile_picture')) {
                \Log::info('Profile picture file found!');
                $file = $request->file('profile_picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/profiles'), $filename);
                $userData['profile_picture'] = $filename;
                \Log::info('Profile picture saved as: ' . $filename);
            } else {
                \Log::info('No profile picture file found in request');
            }

            // Create user with all data
            $user = User::create($userData);

            // Debug: Check what was actually created
            \Log::info('User created:', $user->toArray());

            Log::info("New user registered successfully: ID {$user->id} - {$user->email} with status: PENDING");

            return redirect()->route('login')->with('success', 'Registration successful! Your account is now pending approval. Please wait for admin to activate your account.');
            
        } catch (\Exception $e) {
            \Log::error('Registration failed: ' . $e->getMessage());
            return back()->with('error', 'Registration failed: ' . $e->getMessage())->withInput();
        }
    }
}
