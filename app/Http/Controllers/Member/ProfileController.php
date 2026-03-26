<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the member profile page
     */
    public function show()
    {
        return view('member.profile');
    }

    /**
     * Get current user data via API
     */
    public function getCurrentUser()
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'password' => $user->password, // Note: This should not be exposed in production
                'remember_token' => $user->remember_token, // Note: This should not be exposed in production
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'role' => $user->role,
                'registration_number' => $user->registration_number,
                'home_diocese' => $user->home_diocese,
                'phone_number' => $user->phone_number,
                'profile_picture' => $user->profile_picture,
                'registration_date' => $user->registration_date,
                'gender' => $user->gender,
                'year_of_study' => $user->year_of_study,
                'membership_status' => $user->membership_status,
                'address' => $user->address,
                'date_of_birth' => $user->date_of_birth
            ]
        ]);
    }

    /**
     * Update the member profile
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'phone_number' => 'required|string|max:20',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'year_of_study' => 'nullable|string|in:Year 1,Year 2,Year 3,Year 4,Year 5,Graduate',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'phone_number.required' => 'Please enter your phone number',
            'gender.in' => 'Please select a valid gender',
            'year_of_study.in' => 'Please select a valid year of study',
            'profile_picture.image' => 'Please select a valid image file',
            'profile_picture.mimes' => 'Only JPEG, PNG, and GIF files are allowed',
            'profile_picture.max' => 'Image size must be less than 2MB',
        ]);

        try {
            // Update phone number, gender, and year of study
            $userData = [
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'year_of_study' => $request->year_of_study,
            ];

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                
                // Delete old profile picture if exists
                if ($user->profile_picture && file_exists(public_path('uploads/profiles/' . $user->profile_picture))) {
                    unlink(public_path('uploads/profiles/' . $user->profile_picture));
                }
                
                // Upload new profile picture
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/profiles'), $filename);
                $userData['profile_picture'] = $filename;
            }

            $user->update($userData);

            \Log::info('Profile updated successfully for user: ' . $user->email);

            return redirect('/member/dashboard')->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Profile update failed: ' . $e->getMessage());
            return back()->with('error', 'Profile update failed. Please try again.')->withInput();
        }
    }
}
