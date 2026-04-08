<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Code</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #4a69bd 0%, #6c5ce7 100%); padding: 40px 30px; text-align: center;">
            <h1 style="color: white; margin: 0; font-size: 28px;">TMCS</h1>
            <p style="color: white; margin: 10px 0 0 0; opacity: 0.9;">Tanzania Movement of Catholic Students</p>
        </div>
        
        <!-- Content -->
        <div style="padding: 40px 30px;">
            <h2 style="color: #333; margin: 0 0 20px 0; text-align: center;">Password Reset Code</h2>
            
            <p style="color: #666; font-size: 16px; line-height: 1.5; margin: 0 0 30px 0; text-align: center;">
                Hello {{ $user->name ?? 'Valued Member' }},<br>
                You requested to reset your password. Use the code below to proceed:
            </p>
            
            <!-- OTP Code -->
            <div style="background: #f8f9fa; border: 2px dashed #667eea; border-radius: 8px; padding: 20px; text-align: center; margin: 30px 0;">
                <p style="color: #666; margin: 0 0 10px 0; font-size: 14px;">Your verification code is:</p>
                <div style="font-size: 32px; font-weight: bold; color: #667eea; letter-spacing: 8px; margin: 0;">
                    {{ $otp }}
                </div>
            </div>
            
            <!-- Instructions -->
            <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 30px 0;">
                <p style="color: #856404; margin: 0; font-size: 14px;">
                    <strong>Important:</strong> This code will expire in 10 minutes for security reasons. If you didn't request this password reset, please ignore this email.
                </p>
            </div>
            
            <!-- Footer -->
            <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                <p style="color: #999; margin: 0; font-size: 12px;">
                    If you have any issues, please contact our support team at<br>
                    <a href="mailto:support@tmcs.org" style="color: #667eea;">support@tmcs.org</a>
                </p>
            </div>
        </div>
        
        <!-- Bottom Footer -->
        <div style="background: #f8f9fa; padding: 20px; text-align: center;">
            <p style="color: #666; margin: 0; font-size: 12px;">
                © {{ date('Y') }} TMCS - All rights reserved
            </p>
        </div>
    </div>
</body>
</html>
