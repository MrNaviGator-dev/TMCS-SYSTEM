<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Get all payments for admin
     */
    public function getAllPayments()
    {
        try {
            Log::info('Admin requesting all payments');
            
            // Get all payments with user relationships
            $payments = Payment::with('user')
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info('Found ' . $payments->count() . ' payments');

            return response()->json([
                'success' => true,
                'payments' => $payments,
                'message' => 'Payments retrieved successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching admin payments: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error fetching payments: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve a payment
     */
    public function approvePayment(Request $request, $paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);
            $payment->status = 'completed';
            
            // Get comments from request
            $comments = null;
            $data = $request->all();
            
            // Check if comments is in the request data
            if (isset($data['comments'])) {
                $comments = $data['comments'];
            }
            
            // Add comments to description if provided
            if ($comments) {
                $payment->description = $payment->description ? 
                    $payment->description . "\n\nAdmin Approval Comments: " . $comments : 
                    "Admin Approval Comments: " . $comments;
            }
            
            $payment->save();

            Log::info('Payment approved: ' . $paymentId . ' with comments: ' . ($comments ?? 'none'));

            return response()->json([
                'success' => true,
                'message' => 'Payment approved successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error approving payment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error approving payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject a payment
     */
    public function rejectPayment(Request $request, $paymentId)
    {
        try {
            $payment = Payment::findOrFail($paymentId);
            $payment->status = 'rejected';
            
            // Get rejection reason from request
            $reason = null;
            $data = $request->all();
            
            // Check if reason is in the request data
            if (isset($data['reason'])) {
                $reason = $data['reason'];
            }
            
            // Add rejection reason to description if provided
            if ($reason) {
                $payment->description = $payment->description ? 
                    $payment->description . "\n\nRejection Reason: " . $reason : 
                    "Rejection Reason: " . $reason;
            }
            
            $payment->save();

            Log::info('Payment rejected: ' . $paymentId . ' with reason: ' . ($reason ?? 'none'));

            return response()->json([
                'success' => true,
                'message' => 'Payment rejected successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error rejecting payment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error rejecting payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get payment statistics for dashboard
     */
    public function getPaymentStatistics()
    {
        try {
            $today = now()->format('Y-m-d');
            
            $todayCount = Payment::whereDate('created_at', $today)->count();
            $totalAmount = Payment::where('status', 'completed')->sum('amount');
            $pendingCount = Payment::where('status', 'pending')->count();

            return response()->json([
                'success' => true,
                'today_count' => $todayCount,
                'total_amount' => $totalAmount,
                'pending_count' => $pendingCount
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching payment statistics: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error fetching statistics: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get recent payments for dashboard
     */
    public function getRecentPayments()
    {
        try {
            $payments = Payment::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'payments' => $payments
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching recent payments: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error fetching recent payments: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new payment (admin creating payment)
     */
    public function storePayment(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'payment_type' => 'required|string|in:membership,certificate,zaka,donation,event,other',
                'amount' => 'required|numeric|min:0',
                'description' => 'required|string|max:1000',
                'payment_method' => 'required|string|max:100',
                'sender_name' => 'required|string|max:255',
                'payment_year' => 'required|integer|min:1900|max:2100',
                'installment_type' => 'nullable|string|max:50',
                'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048'
            ]);

            Log::info('Admin payment submission:', [
                'user_id' => $validated['user_id'],
                'amount' => $validated['amount'],
                'payment_type' => $validated['payment_type']
            ]);

            // Handle file upload
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . $file->getClientOriginalName();
                $attachmentPath = $file->storeAs('payment_proofs', $filename, 'public');
            }

            // Create payment record
            $payment = Payment::create([
                'user_id' => $validated['user_id'],
                'payment_type' => $validated['payment_type'],
                'amount' => $validated['amount'],
                'description' => $validated['description'],
                'payment_method' => $validated['payment_method'],
                'sender_name' => $validated['sender_name'],
                'payment_year' => $validated['payment_year'],
                'installment_type' => $validated['installment_type'],
                'attachment' => $attachmentPath,
                'status' => 'completed' // Admin-created payments are automatically completed
            ]);

            Log::info('Payment created successfully:', [
                'payment_id' => $payment->id,
                'amount' => $payment->amount
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully!',
                'payment' => $payment
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing admin payment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing payment: ' . $e->getMessage()
            ], 500);
        }
    }
}
