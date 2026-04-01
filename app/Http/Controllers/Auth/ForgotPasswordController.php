<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\PasswordResetOTP;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function submit(Request $request)
    {
        // Custom validation to return session error
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'email.exists' => 'Email not found in our system'
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first())->withInput();
        }

        try {
            $user = User::where('email', $request->email)->first();

            // Generate 4-digit OTP
            $otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            
            // Store OTP in database
            $user->forgot_otp = $otp;
            $user->forgot_otp_expires_at = Carbon::now()->addMinutes(10);
            $user->save();

            // Send OTP email using Laravel Mail
            Mail::to($user->email)->send(new PasswordResetOTP($otp, $user));

            // Store email in session for verification step
            session(['reset_email' => $request->email, 'show_otp_form' => true]);

            return back()->with('success', 'A 4-digit verification code has been sent to your email address.');

        } catch (\Exception $e) {
            \Log::error('OTP sending error: ' . $e->getMessage());
            return back()->with('error', 'Failed to send verification code. Please try again.')->withInput();
        }

    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:4',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.exists' => 'This email is not registered',
            'otp.required' => 'Please enter the verification code',
            'otp.digits' => 'Verification code must be 4 digits',
            'password.required' => 'Please enter a new password',
            'password.min' => 'Password must be at least 6 characters',
            'password.confirmed' => 'Password confirmation does not match',
        ]);

        try {
            $user = User::where('email', $request->email)
                        ->where('forgot_otp', $request->otp)
                        ->where('forgot_otp_expires_at', '>', Carbon::now())
                        ->first();

            if (!$user) {
                return back()->with('error', 'Invalid or expired verification code. Please try again.')->withInput();
            }

            // Update password
            $user->password = Hash::make($request->password);
            $user->forgot_otp = null;
            $user->forgot_otp_expires_at = null;
            $user->save();

            // Clear session data
            session()->forget(['reset_email', 'show_otp_form']);

            return redirect('/login')->with('success', 'Password has been reset successfully. Please sign in with your new password.');

        } catch (\Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());
            return back()->with('error', 'Password reset failed. Please try again.')->withInput();
        }
    }

    public function resendOTP(Request $request)
    {
        $email = session('reset_email');
        
        if (!$email) {
            return redirect()->route('password.forgot')->with('error', 'Session expired. Please start over.');
        }

        $request->merge(['email' => $email]);
        return $this->submit($request);
    }
}