<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Log;

class PaymentAccountController extends Controller
{
    /**
     * Get all active payment accounts for members
     */
    public function index()
    {
        try {
            // Only return active accounts for members
            $mobileMoneyAccounts = Account::active()->mobile()->get();
            $bankAccounts = Account::active()->bank()->get();
            
            return response()->json([
                'success' => true,
                'mobile_money' => $mobileMoneyAccounts,
                'bank_accounts' => $bankAccounts
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching payment accounts for member: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch payment accounts'
            ], 500);
        }
    }
}
