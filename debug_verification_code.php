<?php
require_once 'vendor/autoload.php';

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetOTP;
use Carbon\Carbon;

echo "<h2>Verification Code Debug Test</h2>";

try {
    // Test 1: Check if we can find a test user
    echo "<h3>Test 1: Finding Test User</h3>";
    $testUser = User::where('email', 'watsonboniface90@yahoo.com')->first();
    
    if ($testUser) {
        echo "<p style='color: green;'>✅ User found: {$testUser->name} (ID: {$testUser->id})</p>";
        
        // Test 2: Generate OTP
        echo "<h3>Test 2: Generating OTP</h3>";
        $otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        echo "<p>Generated OTP: {$otp}</p>";
        
        // Test 3: Save OTP to database
        echo "<h3>Test 3: Saving OTP to Database</h3>";
        $testUser->forgot_otp = $otp;
        $testUser->forgot_otp_expires_at = Carbon::now()->addMinutes(10);
        $saved = $testUser->save();
        
        if ($saved) {
            echo "<p style='color: green;'>✅ OTP saved to database successfully</p>";
            echo "<p>OTP in database: {$testUser->forgot_otp}</p>";
            echo "<p>Expires at: {$testUser->forgot_otp_expires_at}</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to save OTP to database</p>";
        }
        
        // Test 4: Check mail configuration
        echo "<h3>Test 4: Mail Configuration Check</h3>";
        $mailConfig = [
            'MAIL_MAILER' => env('MAIL_MAILER'),
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_USERNAME' => env('MAIL_USERNAME'),
            'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
        ];
        
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Setting</th><th>Value</th></tr>";
        foreach ($mailConfig as $key => $value) {
            echo "<tr><td>{$key}</td><td>" . ($value ?: 'NOT SET') . "</td></tr>";
        }
        echo "</table>";
        
        // Test 5: Try to send email (but don't actually send)
        echo "<h3>Test 5: Email Sending Test</h3>";
        try {
            // Create mail instance but don't send
            $mail = new PasswordResetOTP($otp, $testUser);
            echo "<p style='color: green;'>✅ Mail object created successfully</p>";
            echo "<p>Subject: TMCS Password Reset Code</p>";
            echo "<p>View: emails.password-reset-otp</p>";
            
            // Test if email template exists
            $viewPath = resource_path('views/emails/password-reset-otp.blade.php');
            if (file_exists($viewPath)) {
                echo "<p style='color: green;'>✅ Email template exists</p>";
            } else {
                echo "<p style='color: red;'>❌ Email template not found at: {$viewPath}</p>";
            }
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Mail creation failed: " . $e->getMessage() . "</p>";
        }
        
        // Test 6: Check Laravel logs for mail errors
        echo "<h3>Test 6: Check Recent Laravel Logs</h3>";
        $logPath = storage_path('logs/laravel.log');
        if (file_exists($logPath)) {
            $logContent = file_get_contents($logPath);
            $recentLogs = substr($logContent, -2000); // Last 2000 characters
            echo "<pre style='background: #f5f5f5; padding: 10px; font-size: 12px; max-height: 200px; overflow-y: scroll;'>";
            echo htmlspecialchars($recentLogs);
            echo "</pre>";
        } else {
            echo "<p style='color: orange;'>⚠️ Laravel log file not found</p>";
        }
        
    } else {
        echo "<p style='color: red;'>❌ Test user not found</p>";
    }
    
} catch (Exception $e) {
    echo "<h3 style='color: red;'>❌ Error During Testing</h3>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "<pre style='background: #f5f5f5; padding: 10px;'>";
    echo htmlspecialchars($e->getTraceAsString());
    echo "</pre>";
}
?>
