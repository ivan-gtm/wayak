<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .header {
            background-color: #f2f2f2;
            padding: 10px;
            text-align: center;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Email Verification</h2>
    </div>
    <div class="content">
        <p>Hello {{ $user->name }},</p>
        <p>Thank you for registering on our platform. To complete your registration, please verify your email by clicking the button below:</p>
        <a href="{{ $verificationLink }}" class="button">Verify Email</a>
        <p>If the button doesn't work, you can also click on the link below:</p>
        <p><a href="{{ $verificationLink }}">{{ $verificationLink }}</a></p>
        <p>Thank you,</p>
        <p>The [YOUR_COMPANY_NAME] Team</p>
    </div>
</div>

</body>
</html>
