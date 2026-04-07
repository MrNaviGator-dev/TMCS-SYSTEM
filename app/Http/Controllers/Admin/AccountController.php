<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    /**
     * Display a listing of the accounts.
     */
    public function index()
    {
        try {
            // Get all accounts from the database
            $accounts = Account::orderBy('created_at', 'desc')->get();
            
            // Format created_at for display
            $accounts = $accounts->map(function($account) {
                $account->formatted_created_at = $account->created_at ? $account->created_at->format('M d, Y H:i') : 'N/A';
                return $account;
            });
            
            // Separate accounts by type
            $mobileMoneyAccounts = $accounts->where('account_type', 'mobile')->values();
            $bankAccounts = $accounts->where('account_type', 'bank')->values();
            
            return response()->json([
                'success' => true,
                'mobile_money' => $mobileMoneyAccounts,
                'bank_accounts' => $bankAccounts,
                'all_accounts' => $accounts
            ]);
            
        } catch (\Exception $e) {
            Log::error("Failed to fetch accounts: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch accounts'
            ], 500);
        }
    }

    /**
     * Store a newly created account in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'account_type' => 'required|in:mobile,bank',
                'account_number' => 'required|string|max:30',
                'account_name' => 'required|string|max:100',
                'status' => 'required|in:active,inactive'
            ]);

            $account = Account::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Account added successfully!',
                'account' => $account
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to create account: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create account'
            ], 500);
        }
    }

    /**
     * Update the specified account in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $account = Account::findOrFail($id);

            $validated = $request->validate([
                'account_type' => 'required|in:mobile,bank',
                // 'sender_name' => 'required|string|max:50',
                'account_number' => 'required|string|max:30',
                'account_name' => 'required|string|max:100',
                // 'branch_name' => 'nullable|string|max:100',
                'status' => 'required|in:active,inactive'
            ]);

            $account->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Account updated successfully!',
                'account' => $account
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to update account: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update account'
            ], 500);
        }
    }

    /**
     * Remove the specified account from storage.
     */
    public function destroy($id)
    {
        try {
            $account = Account::findOrFail($id);
            $account->delete();

            return response()->json([
                'success' => true,
                'message' => 'Account deleted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to delete account: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete account'
            ], 500);
        }
    }
}
