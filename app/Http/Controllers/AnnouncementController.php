<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Create a new announcement
     */
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'message' => 'required|string',
                'priority' => 'required|in:normal,important,urgent',
                'audience' => 'required|in:all,members,leaders,admins',
                'expiry_date' => 'nullable|date|after:today',
                'announcement_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('announcement_image')) {
                $file = $request->file('announcement_image');
                $fileName = 'announcement_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->store('announcements', 'public'); // Use Laravel's storage system
                
                // The file is already stored by Laravel, no need to manually copy
                // Laravel's storage link handles the accessibility
            }

            $announcement = DB::table('announcements')->insert([
                'title' => $validated['title'],
                'message' => $validated['message'],
                'priority' => $validated['priority'],
                'audience' => $validated['audience'],
                'expiry_date' => $validated['expiry_date'] ?? null,
                'image' => $imagePath,
                'status' => 'active',
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Announcement created successfully',
                'data' => $announcement
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating announcement: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all announcements
     */
    public function index()
    {
        try {
            $announcements = DB::table('announcements')
                ->join('users', 'announcements.created_by', '=', 'users.id')
                ->select(
                    'announcements.*',
                    'users.name as created_by_name'
                )
                ->where('announcements.status', 'active')
                ->orderBy('announcements.created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $announcements->map(function ($announcement) {
                    return [
                        'id' => $announcement->id,
                        'title' => $announcement->title,
                        'message' => $announcement->message,
                        'priority' => $announcement->priority,
                        'audience' => $announcement->audience,
                        'expiry_date' => $announcement->expiry_date,
                        'image' => $announcement->image ? 'http://localhost:8000/storage/' . $announcement->image : null,
                        'status' => $announcement->status,
                        'created_by' => $announcement->created_by_name,
                        'created_at' => $announcement->created_at,
                        'updated_at' => $announcement->updated_at
                    ];
                })
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching announcements: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an announcement
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'message' => 'required|string',
                'priority' => 'required|in:normal,important,urgent',
                'audience' => 'required|in:all,members,leaders,admins',
                'expiry_date' => 'nullable|date|after:today',
                'image' => 'nullable|string|max:255',
                'status' => 'required|in:active,inactive'
            ]);

            $updated = DB::table('announcements')
                ->where('id', $id)
                ->update([
                    'title' => $validated['title'],
                    'message' => $validated['message'],
                    'priority' => $validated['priority'],
                    'audience' => $validated['audience'],
                    'expiry_date' => $validated['expiry_date'] ?? null,
                    'image' => $validated['image'] ?? null,
                    'status' => $validated['status'],
                    'updated_by' => Auth::id(),
                    'updated_at' => now()
                ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Announcement updated successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Announcement not found'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating announcement: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete an announcement
     */
    public function destroy($id)
    {
        try {
            $deleted = DB::table('announcements')
                ->where('id', $id)
                ->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Announcement deleted successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Announcement not found'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting announcement: ' . $e->getMessage()
            ], 500);
        }
    }
}
