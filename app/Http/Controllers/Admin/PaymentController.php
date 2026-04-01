<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Account;
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

    public function storePersonalPayment(Request $request)
    {
        try {
            // Get the raw payment method value
            $paymentMethod = $request->input('payment_method');
            
            // Handle dynamic payment account values (mobile_1, bank_2, etc.)
            $actualPaymentMethod = $paymentMethod;
            if (strpos($paymentMethod, 'mobile_') === 0) {
                $actualPaymentMethod = 'mobile_money';
            } elseif (strpos($paymentMethod, 'bank_') === 0) {
                $actualPaymentMethod = 'bank_transfer';
            }
            
            // Validate request
            $validated = $request->validate([
                'payment_type' => 'required|string|in:membership,certificate,zaka,donation,event,other',
                'amount' => 'required|numeric|min:0',
                'description' => 'required|string|max:1000',
                'payment_method' => 'required|string', // Remove strict validation to accept dynamic values
                'sender_name' => 'required|string|max:255',
                'attachment' => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
                'payment_year' => 'required|string',
                'custom_year' => 'nullable|integer|min:2020|max:2050',
                'installment_type' => 'nullable|string|in:full',
                'user_id' => 'required|exists:users,id'
            ]);

            // Handle file upload
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $filename = time() . '_' . $file->getClientOriginalName();
                $attachmentPath = $file->storeAs('payment_proofs', $filename, 'public');
            }

            // Determine payment year
            $paymentYear = $validated['payment_year'];
            if ($paymentYear === 'custom_year' && !empty($validated['custom_year'])) {
                $paymentYear = $validated['custom_year'];
            }

            // Create the payment record for admin
            $payment = Payment::create([
                'user_id' => $validated['user_id'], // Admin's user ID
                'payment_type' => $validated['payment_type'],
                'amount' => $validated['amount'],
                'description' => $validated['description'],
                'payment_method' => $actualPaymentMethod, // Use the processed payment method
                'sender_name' => $validated['sender_name'],
                'installment_type' => $validated['installment_type'] ?? null,
                'payment_year' => $paymentYear,
                'attachment' => $attachmentPath,
                'status' => 'completed' // Admin payments are automatically completed
            ]);

            Log::info('Admin personal payment created: ' . $payment->id . ' by user: ' . $validated['user_id']);

            return response()->json([
                'success' => true,
                'message' => 'Payment submitted successfully! Your payment has been recorded as completed.',
                'payment' => $payment
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in admin personal payment: ' . json_encode($e->errors()));
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error storing admin personal payment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get payment accounts for dropdown
     */
    public function getPaymentAccounts()
    {
        try {
            Log::info('Admin requesting payment accounts');
            
            // Get all active accounts
            $accounts = Account::active()->get();
            
            Log::info('Found accounts: ' . $accounts->count());
            
            // Group accounts by type for better organization
            $mobileAccounts = $accounts->where('account_type', 'mobile');
            $bankAccounts = $accounts->where('account_type', 'bank');
            
            return response()->json([
                'success' => true,
                'accounts' => $accounts,
                'mobile_accounts' => $mobileAccounts,
                'bank_accounts' => $bankAccounts
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching payment accounts: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error fetching payment accounts: ' . $e->getMessage()
            ], 500);
        }
    }
}
