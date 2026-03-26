<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form
     */
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password request
     */
    public function submit(Request $request)
    {
        // Check if this is the first step (phone number only)
        if (!$request->has('new_password') && !$request->has('security_answer')) {
            $request->validate([
                'phone_number' => 'required|string',
            ], [
                'phone_number.required' => 'Please enter your phone number',
            ]);

            try {
                // Normalize phone number and find user
                $phoneNumber = $request->phone_number;
                
                // Remove any non-digit characters
                $cleanPhone = preg_replace('/[^0-9]/', '', $phoneNumber);
                
                // Try different formats
                $possibleFormats = [
                    $cleanPhone,                    // Original format
                    '255' . substr($cleanPhone, -9), // Ensure 255 prefix
                    substr($cleanPhone, -9),        // Last 9 digits
                    ltrim($cleanPhone, '0'),         // Remove leading 0
                    '0' . substr($cleanPhone, -9),   // Add 0 prefix
                ];
                
                $user = null;
                foreach ($possibleFormats as $format) {
                    $user = User::where('phone_number', $format)->first();
                    if ($user) {
                        \Log::info("User found with phone format: {$format}");
                        break;
                    }
                }
                
                if (!$user) {
                    \Log::warning("Password reset failed: User not found with phone number: {$phoneNumber}");
                    return back()->with('error', 'Phone number not found in our system')->withInput();
                }

                // Store phone number in session and show password form
                session(['phone_number' => $request->phone_number, 'show_password_form' => true]);

                \Log::info("Password reset initiated for phone number: {$request->phone_number}");

                return back()->with('success', 'Account found! Please answer the security question and set a new password.');

            } catch (\Exception $e) {
                \Log::error('Password lookup error: ' . $e->getMessage());
                return back()->with('error', 'Account lookup failed. Please try again.')->withInput();
            }
        }

        // This is the second step (password reset)
        $request->validate([
            'phone_number' => 'required|string',
            'security_answer' => 'required|string',
            'new_password' => 'required|min:6',
            'password_confirmation' => 'required|same:new_password',
        ], [
            'phone_number.required' => 'Please enter your phone number',
            'security_answer.required' => 'Please answer the security question',
            'new_password.required' => 'Please enter a new password',
            'new_password.min' => 'Password must be at least 6 characters',
            'password_confirmation.required' => 'Please confirm your new password',
            'password_confirmation.same' => 'Password confirmation does not match',
        ]);

        try {
            // Normalize phone number and find user
            $phoneNumber = $request->phone_number;
            
            // Remove any non-digit characters
            $cleanPhone = preg_replace('/[^0-9]/', '', $phoneNumber);
            
            // Try different formats
            $possibleFormats = [
                $cleanPhone,                    // Original format
                '255' . substr($cleanPhone, -9), // Ensure 255 prefix
                substr($cleanPhone, -9),        // Last 9 digits
                ltrim($cleanPhone, '0'),         // Remove leading 0
                '0' . substr($cleanPhone, -9),   // Add 0 prefix
            ];
            
            $user = null;
            foreach ($possibleFormats as $format) {
                $user = User::where('phone_number', $format)->first();
                if ($user) {
                    \Log::info("User found with phone format: {$format}");
                    break;
                }
            }
            
            if (!$user) {
                \Log::warning("Password reset failed: User not found with phone number: {$phoneNumber}");
                return back()->with('error', 'Phone number not found in our system')->withInput();
            }

            // Check security answer (for demo, we'll use a simple check)
            // In a real application, you would store and check actual security answers
            $validAnswers = ['moravian', 'catholic', 'anglican', 'pentecostal', 'methodist', 'lutheran', 'baptist', 'presbyterian'];
            $userAnswer = strtolower(trim($request->security_answer));
            
            if (!in_array($userAnswer, $validAnswers)) {
                \Log::warning("Password reset failed: Invalid security answer for phone number: {$phoneNumber}");
                return back()->with('error', 'Invalid security answer. Please try again.')->withInput();
            }

            // Update password
            $user->password = Hash::make($request->new_password);
            $user->save();

            // Clear session data
            session()->forget(['phone_number', 'show_password_form']);

            \Log::info("Password reset successful for user: {$user->email} (Phone: {$request->phone_number})");

            return redirect('/login')->with('success', 'Password has been reset successfully. Please sign in with your new password.');

        } catch (\Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());
            return back()->with('error', 'Password reset failed. Please try again.')->withInput();
        }
    }
}
