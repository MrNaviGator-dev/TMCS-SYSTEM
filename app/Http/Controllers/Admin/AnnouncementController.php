<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements.
     */
    public function index()
    {
        $announcements = Announcement::with(['creator', 'updater'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'announcements' => $announcements->map(function ($announcement) {
                return [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'message' => $announcement->message,
                    'priority' => $announcement->priority,
                    'audience' => $announcement->audience,
                    'expiry_date' => $announcement->expiry_date ? $announcement->expiry_date->format('Y-m-d') : null,
                    'image' => $announcement->image ? 'http://localhost:8000/storage/' . $announcement->image : null,
                    'status' => $announcement->status,
                    'created_by' => $announcement->creator ? $announcement->creator->name : 'Unknown',
                    'created_at' => $announcement->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $announcement->updated_at->format('Y-m-d H:i:s')
                ];
            })
        ]);
    }

    /**
     * Store a newly created announcement.
     */
    public function store(Request $request)
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to create announcements.'
                ], 401);
            }

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'message' => 'required|string',
                'priority' => 'required|in:normal,important,urgent',
                'audience' => 'required|in:all,leaders,members,executive',
                'expiry_date' => 'nullable|date|after_or_equal:today',
                'announcement_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $announcement = new Announcement();
            $announcement->title = $validated['title'];
            $announcement->message = $validated['message'];
            $announcement->priority = $validated['priority'];
            $announcement->audience = $validated['audience'];
            $announcement->expiry_date = $validated['expiry_date'] ?? null;
            $announcement->status = 'active';
            $announcement->created_by = Auth::id();
            $announcement->updated_by = Auth::id();

            // Handle image upload
            if ($request->hasFile('announcement_image')) {
                $image = $request->file('announcement_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('announcements', $imageName, 'public');
                $announcement->image = $imagePath;
            }

            $announcement->save();

            return response()->json([
                'success' => true,
                'message' => 'Announcement created successfully!',
                'announcement' => [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'message' => $announcement->message,
                    'priority' => $announcement->priority,
                    'audience' => $announcement->audience,
                    'expiry_date' => $announcement->expiry_date ? $announcement->expiry_date->format('Y-m-d') : null,
                    'image' => $announcement->image ? 'http://localhost:8000/storage/' . $announcement->image : null,
                    'status' => $announcement->status,
                    'created_by' => $announcement->creator ? $announcement->creator->name : 'Unknown',
                    'created_at' => $announcement->created_at->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->errors())
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Announcement creation error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Error creating announcement: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified announcement.
     */
    public function show($id)
    {
        $announcement = Announcement::with(['creator', 'updater'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'announcement' => [
                'id' => $announcement->id,
                'title' => $announcement->title,
                'message' => $announcement->message,
                'priority' => $announcement->priority,
                'audience' => $announcement->audience,
                'expiry_date' => $announcement->expiry_date ? $announcement->expiry_date->format('Y-m-d') : null,
                'image' => $announcement->image ? 'http://localhost:8000/storage/' . $announcement->image : null,
                'status' => $announcement->status,
                'created_by' => $announcement->creator ? $announcement->creator->name : 'Unknown',
                'created_at' => $announcement->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $announcement->updated_at->format('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * Update the specified announcement.
     */
    public function update(Request $request, $id)
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to update announcements.'
                ], 401);
            }

            $announcement = Announcement::findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'message' => 'required|string',
                'priority' => 'required|in:normal,important,urgent',
                'audience' => 'required|in:all,members,leaders,admins',
                'expiry_date' => 'nullable|date|after_or_equal:today',
                'announcement_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'remove_current_image' => 'nullable|boolean'
            ]);

            $announcement->title = $validated['title'];
            $announcement->message = $validated['message'];
            $announcement->priority = $validated['priority'];
            $announcement->audience = $validated['audience'];
            $announcement->expiry_date = $validated['expiry_date'] ?? null;
            $announcement->updated_by = Auth::id();

            // Handle image removal
            if ($request->has('remove_current_image') && $request->boolean('remove_current_image')) {
                // Delete old image if exists
                if ($announcement->image) {
                    Storage::disk('public')->delete($announcement->image);
                    $announcement->image = null;
                }
            }

            // Handle new image upload
            if ($request->hasFile('announcement_image')) {
                // Delete old image if exists
                if ($announcement->image) {
                    Storage::disk('public')->delete($announcement->image);
                }

                $image = $request->file('announcement_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('announcements', $imageName, 'public');
                $announcement->image = $imagePath;
            }

            $announcement->save();

            return response()->json([
                'success' => true,
                'message' => 'Announcement updated successfully!',
                'announcement' => [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'message' => $announcement->message,
                    'priority' => $announcement->priority,
                    'audience' => $announcement->audience,
                    'expiry_date' => $announcement->expiry_date ? $announcement->expiry_date->format('Y-m-d') : null,
                    'image' => $announcement->image ? 'http://localhost:8000/storage/' . $announcement->image : null,
                    'status' => $announcement->status,
                    'created_by' => $announcement->creator ? $announcement->creator->name : 'Unknown',
                    'created_at' => $announcement->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $announcement->updated_at->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Announcement validation error: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->errors())
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Announcement update error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            \Log::error('Request data: ' . json_encode($request->all()));
            return response()->json([
                'success' => false,
                'message' => 'Error updating announcement: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified announcement.
     */
    public function destroy($id)
    {
        try {
            $announcement = Announcement::findOrFail($id);

            // Delete image if exists
            if ($announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }

            $announcement->delete();

            return response()->json([
                'success' => true,
                'message' => 'Announcement deleted successfully!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Announcement deletion error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting announcement: ' . $e->getMessage()
            ], 500);
        }
    }
}
