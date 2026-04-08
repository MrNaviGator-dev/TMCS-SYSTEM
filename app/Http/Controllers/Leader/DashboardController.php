<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Account;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        // Get authenticated user
        $user = Auth::user();
        
        // Debug user data - show what's actually in database
        \Log::info('User ID: ' . $user->id);
        \Log::info('User name: ' . $user->name);
        \Log::info('User email: ' . $user->email);
        \Log::info('User phone_number: ' . ($user->phone_number ?? 'NULL'));
        \Log::info('User gender: ' . ($user->gender ?? 'NULL'));
        \Log::info('User home_diocese: ' . ($user->home_diocese ?? 'NULL'));
        \Log::info('User year_of_study: ' . ($user->year_of_study ?? 'NULL'));
        \Log::info('User role: ' . ($user->role ?? 'NULL'));
        \Log::info('User registration_number: ' . ($user->registration_number ?? 'NULL'));
        \Log::info('User membership_status: ' . ($user->membership_status ?? 'NULL'));
        
// Get user data (excluding user ID 16)
        $activeUsers = User::where('membership_status', 'Active')->where('id', '!=', 16)->count();
        $pendingApprovalUsers = User::where('id', '!=', 16)->orderBy('created_at', 'desc')->get(); // Fetch all users for display
        $pendingUsers = User::where('membership_status', 'Pending')->where('id', '!=', 16)->count(); // Real pending users count
        
        // Get payment statistics
        $totalPayments = Payment::where('status', 'completed')->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->count();
        $completedPayments = Payment::where('status', 'completed')->count();
        
// Get member statistics (excluding user ID 16)
        $totalUsers = User::where('id', '!=', 16)->count();
        $activeUsers = User::where('membership_status', 'Active')->where('id', '!=', 16)->count();
        $activeMembers = User::where('membership_status', 'Active')->where('id', '!=', 16)->count();
        $newMembers = User::where('created_at', '>=', now()->subDays(30))->where('id', '!=', 16)->count();
        $pendingMembers = User::where('membership_status', 'Pending')->where('id', '!=', 16)->count();
        $premiumMembers = User::where('membership_status', 'Premium')->where('id', '!=', 16)->count();
        
        // Debug: Check all possible membership statuses
        $allStatuses = User::pluck('membership_status')->unique();
        \Log::info('All membership statuses found: ' . $allStatuses->implode(', '));
        \Log::info('Pending members count: ' . $pendingMembers);
        \Log::info('Active members count: ' . $activeMembers);
        
// Get all users for manage users section (excluding user ID 16)
        $allUsers = User::where('id', '!=', 16)->orderBy('created_at', 'desc')->get();
        
        // Debug: Check if we have pending users
        if ($pendingApprovalUsers->isEmpty()) {
            \Log::info('No pending users found');
            \Log::info('All users with their status: ' . User::pluck('membership_status')->unique()->implode(', '));
        } else {
            \Log::info('Found pending users: ' . $pendingApprovalUsers->count());
            foreach ($pendingApprovalUsers as $pendingUser) {
                \Log::info('Pending user: ' . $pendingUser->name . ' - ID: ' . $pendingUser->id . ' - Status: ' . $pendingUser->membership_status);
            }
        }
        
        return view('leader.dashboard', compact(
            'totalUsers',
            'activeUsers', 
            'pendingUsers',
            'allUsers',
            'pendingApprovalUsers',
            'totalPayments',
            'pendingPayments',
            'completedPayments',
            'activeMembers',
            'newMembers',
            'pendingMembers',
            'premiumMembers'
        ));
    }
    
    public function getUserDetails($userId)
    {
        try {
            $user = User::findOrFail($userId);
            
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'membership_status' => $user->membership_status,
                    'gender' => $user->gender,
                    'year_of_study' => $user->year_of_study,
                    'address' => $user->address,
                    'date_of_birth' => $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('M d, Y') : 'Not specified',
                    'phone_number' => $user->phone_number,
                    'registration_number' => $user->registration_number,
                    'home_diocese' => $user->home_diocese,
                    'profile_picture' => $user->profile_picture ?: null,
                    'avatar' => $user->avatar ?: null,
                    'registration_date' => $user->registration_date ? \Carbon\Carbon::parse($user->registration_date)->format('M j, Y') : 'Not specified',
                    'created_at' => $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('M j, Y h:i A') : 'Not specified',
                    'updated_at' => $user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->format('M j, Y h:i A') : 'Not specified',
                    'email_verified_at' => $user->email_verified_at ? \Carbon\Carbon::parse($user->email_verified_at)->format('M j, Y h:i A') : 'Not verified',
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found or error occurred: ' . $e->getMessage()
            ], 404);
        }
    }
    
    public function getUserProfilePicture($userId)
    {
        try {
            $user = User::findOrFail($userId);
            
            $profilePicture = null;
            if ($user->profile_picture) {
                // Check if it's a full URL or just filename
                if (filter_var($user->profile_picture, FILTER_VALIDATE_URL)) {
                    $profilePicture = $user->profile_picture;
                } else {
                    $profilePicture = asset('uploads/profiles/' . $user->profile_picture);
                }
            } elseif ($user->avatar) {
                // Check if it's a full URL or just filename
                if (filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                    $profilePicture = $user->avatar;
                } else {
                    $profilePicture = asset('uploads/profiles/' . $user->avatar);
                }
            }
            
            return response()->json([
                'success' => true,
                'profile_picture' => $profilePicture,
                'has_profile_picture' => !empty($user->profile_picture) || !empty($user->avatar),
                'filename' => $user->profile_picture ?: $user->avatar ?: null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found or error occurred: ' . $e->getMessage()
            ], 404);
        }
    }
    
    public function checkSession(Request $request)
    {
        if (Auth::check() && Auth::user()->id != 16) {
            return response()->json([
                'authenticated' => true,
                'status' => 'session_valid',
                'user' => Auth::user()
            ]);
        } else {
            // If user ID 16 or not authenticated, force logout
            if (Auth::check()) {
                Auth::logout();
            }
            return response()->json([
                'authenticated' => false,
                'status' => 'session_expired',
                'message' => 'Session expired. Please login again.'
            ]);
        }
    }

    /**
     * Get payment accounts for leaders
     */
    public function getAccounts()
    {
        try {
            // Get all active accounts from database
            $accounts = Account::where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $accounts
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch accounts: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Validate request
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'phone_number' => 'nullable|string|max:20',
                'home_diocese' => 'nullable|string|max:255',
                'gender' => 'nullable|in:Male,Female,Other',
                'year_of_study' => 'nullable|string|max:255',
                'profilePictureUpload' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ];
            
            // Only validate password fields if newPassword is provided
            if ($request->filled('newPassword')) {
                $rules['currentPassword'] = 'required|string';
                $rules['newPassword'] = 'required|string|min:6|confirmed';
            }
            
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . $validator->errors()->first()
                ], 400);
            }
            
            // Update basic information
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->home_diocese = $request->home_diocese;
            $user->gender = $request->gender;
            $user->year_of_study = $request->year_of_study;
            
            // Update password if provided
            if ($request->filled('newPassword')) {
                if (!password_verify($request->currentPassword, $user->password)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Current password is incorrect'
                    ], 400);
                }
                
                $user->password = bcrypt($request->newPassword);
            }
            
            // Handle profile picture upload
            if ($request->hasFile('profilePictureUpload')) {
                $file = $request->file('profilePictureUpload');
                
                // Delete old profile picture if exists
                if ($user->profile_picture) {
                    $oldPath = public_path('uploads/profiles/' . $user->profile_picture);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                
                // Upload new profile picture
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/profiles'), $filename);
                $user->profile_picture = $filename;
            }
            
            // Save user
            $user->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'home_diocese' => $user->home_diocese,
                    'gender' => $user->gender,
                    'year_of_study' => $user->year_of_study,
                    'role' => $user->role,
                    'registration_number' => $user->registration_number,
                    'created_at' => $user->created_at,
                    'profile_picture' => $user->profile_picture
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating profile: ' . $e->getMessage()
            ], 500);
        }
    }
}
