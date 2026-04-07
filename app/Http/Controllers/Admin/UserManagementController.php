<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Store a new member
     */
    public function storeNewMember(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,leader,member',
            'home_diocese' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'registration_number' => 'nullable|string|max:255',
            'year_of_study' => 'nullable|string|max:255',
            'membership_status' => 'nullable|string|in:Active,Inactive',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Handle profile picture upload
            $profilePicturePath = null;
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/profiles'), $filename);
                $profilePicturePath = $filename;
            }

            // Create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'home_diocese' => $request->home_diocese,
                'gender' => $request->gender,
                'registration_number' => $request->registration_number,
                'year_of_study' => $request->year_of_study,
                'membership_status' => $request->membership_status ?? 'Active',
                'profile_picture' => $profilePicturePath,
                'registration_date' => now(),
                'email_verified_at' => now(), // Auto-verify since admin is creating
            ]);

            Log::info("New member created by admin: ID {$user->id}, Email: {$user->email}, Role: {$user->role}");

            return redirect()->back()->with('success', 'New TMCS member created successfully!');

        } catch (\Exception $e) {
            Log::error("Failed to create new member: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create new member: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user role
     */
    public function updateRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:admin,leader,member'
        ]);

        try {
            $user = User::find($request->user_id);
            $oldRole = $user->role;
            $user->role = $request->role;
            $user->save();

            Log::info("User role updated: ID {$user->id} from {$oldRole} to {$request->role} by admin");

            return response()->json([
                'success' => true,
                'message' => "User role updated successfully from {$oldRole} to {$request->role}"
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to update user role: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user role'
            ], 500);
        }
    }

    /**
     * Update user status
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:Active,Pending,Inactive'
        ]);

        try {
            $user = User::find($request->user_id);
            $oldStatus = $user->membership_status ?? 'Active';
            $user->membership_status = $request->status;
            $user->save();

            Log::info("User status updated: ID {$user->id} from {$oldStatus} to {$request->status} by admin");

            return response()->json([
                'success' => true,
                'message' => "User status updated successfully from {$oldStatus} to {$request->status}"
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to update user status: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user status'
            ], 500);
        }
    }

    /**
     * Approve pending user
     */
    public function approveUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        try {
            $user = User::find($request->user_id);
            
            if ($user->membership_status !== 'Pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not in pending status'
                ], 400);
            }

            $user->membership_status = 'Active';
            $user->save();

            Log::info("User approved: ID {$user->id} - {$user->email} by admin");

            return response()->json([
                'success' => true,
                'message' => "User {$user->name} has been approved successfully and can now login"
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to approve user: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve user'
            ], 500);
        }
    }

    /**
     * Reject pending user
     */
    public function rejectUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        try {
            $user = User::find($request->user_id);
            
            if ($user->membership_status !== 'Pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not in pending status'
                ], 400);
            }

            $user->membership_status = 'Inactive';
            $user->save();

            Log::info("User rejected: ID {$user->id} - {$user->email} by admin");

            return response()->json([
                'success' => true,
                'message' => "User {$user->name} has been rejected and cannot login"
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to reject user: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject user'
            ], 500);
        }
    }

    /**
     * Get full user details
     */
    public function getUserDetails($userId)
    {
        try {
            // Debug: Log the request
            Log::info("getUserDetails called with userId: " . $userId);
            
            $user = User::find($userId);
            
            if (!$user) {
                Log::warning("User not found with ID: " . $userId);
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            Log::info("User found: " . json_encode($user->toArray()));
            
            return response()->json([
                'success' => true,
                'user' => $user
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to get user details: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load user details'
            ], 500);
        }
    }

    /**
     * Process top up
     */
    public function processTopUp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:100',
            'payment_method' => 'required|in:mobile,bank,cash',
            'description' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:100'
        ]);

        try {
            $user = User::find($request->user_id);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Create payment record (you'll need to create a Payment model)
            $payment = [
                'user_id' => $user->id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'description' => $request->description,
                'transaction_id' => $request->transaction_id,
                'status' => 'completed',
                'created_at' => now()
            ];

            // Log the top up
            Log::info("Top up processed for user {$user->id} - {$user->name}: TZS {$request->amount} via {$request->payment_method}");

            return response()->json([
                'success' => true,
                'message' => "Top up of TZS {$request->amount} processed successfully for {$user->name}"
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to process top up: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process top up'
            ], 500);
        }
    }

    /**
     * Update user information
     */
    public function updateUser(Request $request)
    {
        try {
            // Debug: Log incoming data
            Log::info("Update user request data: " . json_encode($request->all()));
            
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $request->user_id,
                'phone_number' => 'required|string|max:20|unique:users,phone_number,' . $request->user_id,
                'registration_number' => 'nullable|string|unique:users,registration_number,' . $request->user_id,
                'home_diocese' => 'required|string|max:255',
                'gender' => 'required|in:Male,Female,Other',
                'year_of_study' => 'nullable|in:Year 1,Year 2,Year 3,Year 4,Year 5,Year 6,Graduate,Alumni,Staff',
                'role' => 'required|in:admin,leader,member',
                'membership_status' => 'required|in:Active,Pending,Inactive',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'password' => 'nullable|min:6',
                'password_confirmation' => 'required_with:password|same:password'
            ], [
            'email.unique' => 'This email is already taken by another user',
            'phone_number.unique' => 'This phone number is already taken by another user',
            'registration_number.unique' => 'This registration number is already taken by another user',
            'password.min' => 'Password must be at least 6 characters',
            'password_confirmation.same' => 'Password confirmation does not match'
        ]);

            $user = User::find($request->user_id);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Update user data
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->registration_number = $request->registration_number;
            $user->home_diocese = $request->home_diocese;
            $user->gender = $request->gender;
            $user->year_of_study = $request->year_of_study;
            $user->role = $request->role;
            $user->membership_status = $request->membership_status;

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                
                // Delete old profile picture if exists
                if ($user->profile_picture) {
                    $oldFilePath = public_path('uploads/profiles/' . $user->profile_picture);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                
                // Upload new profile picture
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/profiles'), $filename);
                $user->profile_picture = $filename;
                
                Log::info("Profile picture updated for user ID {$user->id} - {$user->email}: {$filename}");
            }

            // Update password if provided
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            Log::info("User updated successfully: ID {$user->id} - {$user->email} by admin");

            return response()->json([
                'success' => true,
                'message' => "User {$user->name} has been updated successfully"
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to update user: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete user
     */
    public function deleteUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        try {
            $user = User::find($request->user_id);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $userName = $user->name;
            $userEmail = $user->email;
            
            // Delete the user
            $user->delete();

            Log::info("User deleted successfully: ID {$request->user_id} - {$userName} ({$userEmail}) by admin");

            return response()->json([
                'success' => true,
                'message' => "User {$userName} has been deleted successfully"
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to delete user: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk approve users
     */
    public function bulkApproveUsers(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        try {
            $userIds = $request->user_ids;
            $updatedCount = User::whereIn('id', $userIds)
                ->where('membership_status', 'Pending')
                ->update(['membership_status' => 'Active']);

            Log::info("Bulk approved {$updatedCount} users. User IDs: " . implode(', ', $userIds));

            return response()->json([
                'success' => true,
                'message' => "Successfully approved {$updatedCount} users"
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to bulk approve users: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve users: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk reject users
     */
    public function bulkRejectUsers(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        try {
            $userIds = $request->user_ids;
            $updatedCount = User::whereIn('id', $userIds)
                ->where('membership_status', 'Pending')
                ->update(['membership_status' => 'Inactive']);

            Log::info("Bulk rejected {$updatedCount} users. User IDs: " . implode(', ', $userIds));

            return response()->json([
                'success' => true,
                'message' => "Successfully rejected {$updatedCount} users"
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to bulk reject users: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject users: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete users
     */
    public function bulkDeleteUsers(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        try {
            $userIds = $request->user_ids;
            $deletedCount = User::whereIn('id', $userIds)->delete();

            Log::info("Bulk deleted {$deletedCount} users. User IDs: " . implode(', ', $userIds));

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} users"
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to bulk delete users: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete users: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current authenticated user
     */
    public function getCurrentUser()
    {
        try {
            $user = auth()->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            return response()->json([
                'success' => true,
                'user' => $user
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to get current user: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get current user'
            ], 500);
        }
    }

    /**
     * Change admin password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'new_password_confirmation' => 'required|same:new_password'
        ]);

        try {
            $user = User::find($request->user_id);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 422);
            }

            // Update password
            $user->password = Hash::make($request->new_password);
            $user->save();

            Log::info("Password changed successfully for user ID {$user->id} - {$user->email}");

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to change password: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to change password'
            ], 500);
        }
    }

    /**
     * Update admin profile picture
     */
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $user = User::find($request->user_id);
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                
                // Delete old profile picture if exists
                if ($user->profile_picture) {
                    $oldFilePath = public_path('uploads/profiles/' . $user->profile_picture);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                
                // Upload new profile picture
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/profiles'), $filename);
                $user->profile_picture = $filename;
                
                Log::info("Profile picture updated for user ID {$user->id} - {$user->email}: {$filename}");
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile picture updated successfully',
                'profile_picture' => $user->profile_picture
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to update profile picture: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile picture: ' . $e->getMessage()
            ], 500);
        }
    }
}
