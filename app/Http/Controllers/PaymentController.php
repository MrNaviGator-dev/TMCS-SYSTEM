<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Store a new payment
     */
    public function store(Request $request)
    {
        try {
            // Log incoming request data for debugging
            \Log::info('Payment submission attempt:', [
                'all_data' => $request->all(),
                'has_files' => $request->hasFile('attachment'),
                'files' => $request->files->all()
            ]);
            
            // Validate request with conditional rules
            $rules = [
                'payment_type' => 'required|string|in:membership,certificate,zaka',
                'amount' => 'required|numeric|min:0',
                'description' => 'required|string|max:1000',
                'payment_method' => 'required|string|max:100',
                'sender_name' => 'required|string|max:255',
                'installment_type' => 'nullable|string|max:50',
                'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048'
            ];
            
            // Handle payment year validation - check if custom_year is provided
            if ($request->has('custom_year') && $request->custom_year) {
                $rules['custom_year'] = 'required|integer|min:1900|max:2100';
            } else {
                $rules['payment_year'] = 'required|integer|min:1900|max:2100';
            }
            
            $validated = $request->validate($rules);

            Log::info('Payment validation passed:', $validated);

            // Handle payment year (use custom_year if provided, otherwise use payment_year)
            $paymentYear = $validated['custom_year'] ?? $validated['payment_year'] ?? date('Y');

            // Handle file upload
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $fileName = 'payment_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $attachmentPath = $file->storeAs('payments', $fileName, 'public');
            }

            // Create payment record
            $payment = Payment::create([
                'user_id' => Auth::id(),
                'payment_type' => $validated['payment_type'],
                'amount' => $validated['amount'],
                'description' => $validated['description'],
                'payment_method' => $validated['payment_method'],
                'sender_name' => $validated['sender_name'],
                'installment_type' => $validated['installment_type'] ?? null,
                'payment_year' => $paymentYear,
                'attachment' => $attachmentPath,
                'status' => 'pending'
            ]);

            Log::info('Payment created successfully:', $payment->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Payment submitted successfully!',
                'payment' => $payment
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            Log::error('Payment validation failed:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->errors()->all())
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error submitting payment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error submitting payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's payment history
     */
    public function history()
    {
        try {
            // Get only payments for the authenticated user
            $payments = Payment::where('user_id', Auth::id())
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->get();
            
            \Log::info("Payment history called for user " . Auth::id() . " - Found " . $payments->count() . " payments");
            
            return response()->json([
                'success' => true,
                'payments' => $payments,
                'user_role' => Auth::user()->role
            ]);

        } catch (\Exception $e) {
            \Log::error('Error loading payment history: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading payment history: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's payment summary
     */
    public function paymentSummary()
    {
        try {
            $userId = Auth::id();
            
            // Get payments grouped by status (include both approved and completed as approved)
            $approvedAmount = Payment::where('user_id', $userId)
                ->whereIn('status', ['approved', 'completed'])
                ->sum('amount');
            
            $approvedCount = Payment::where('user_id', $userId)
                ->whereIn('status', ['approved', 'completed'])
                ->count();
            
            $pendingAmount = Payment::where('user_id', $userId)
                ->where('status', 'pending')
                ->sum('amount');
            
            $rejectedAmount = Payment::where('user_id', $userId)
                ->where('status', 'rejected')
                ->sum('amount');
            
            // Total amount should only include approved/completed payments
            $totalAmount = Payment::where('user_id', $userId)
                ->whereIn('status', ['approved', 'completed'])
                ->sum('amount');
            
            \Log::info("Payment summary for user {$userId}: Approved={$approvedAmount} ({$approvedCount} payments), Pending={$pendingAmount}, Rejected={$rejectedAmount}, Total={$totalAmount}");
            
            return response()->json([
                'success' => true,
                'summary' => [
                    'approved_amount' => $approvedAmount,
                    'approved_count' => $approvedCount,
                    'pending_amount' => $pendingAmount,
                    'rejected_amount' => $rejectedAmount,
                    'total_amount' => $totalAmount
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error loading payment summary: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading payment summary: ' . $e->getMessage()
            ], 500);
        }
    }
}
