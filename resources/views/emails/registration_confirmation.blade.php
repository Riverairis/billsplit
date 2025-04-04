<!DOCTYPE html>
<html>
<head>
    <title>Welcome to BillSplit</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #4a6baf; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .button { display: inline-block; padding: 10px 20px; background-color: #4a6baf; color: white; text-decoration: none; border-radius: 5px; }
        .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; text-align: center; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to BillSplit!</h1>
        </div>
        
        <div class="content">
            <p>Hello {{ $user->nickname }},</p>
            
            <p>Thank you for registering with BillSplit. We're excited to have you on board!</p>
            
            <p>With BillSplit, you can easily split bills with friends and family, track expenses, and manage shared costs.</p>
            
            <p>To get started, please login to your account:</p>
            
            <p style="text-align: center; margin: 30px 0;">
                <a href="{{ route('login') }}" class="button">Login to Your Account</a>
            </p>
            
            <p>If you have any questions or need assistance, feel free to reply to this email.</p>
            
            <p>Happy splitting!</p>
            
            <p>The BillSplit Team</p>
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} BillSplit. All rights reserved.
        </div>
    </div>
</body>
</html>