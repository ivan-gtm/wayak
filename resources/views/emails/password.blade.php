<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            line-height: 1.5;
            color: #333;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
        }

        .content {
            margin-bottom: 20px;
        }

        .btn {
            display: block;
            width: 100%;
            max-width: 200px;
            margin: 20px auto;
            padding: 10px 15px;
            background-color: #007BFF;
            color: #ffffff;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .footer {
            font-size: 0.9em;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://wayak.app/assets/img/logo.png" alt="Company Logo">
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>You recently requested to reset your password for your account. Click the button below to reset it.</p>
            <a href="{{ url('password/reset/'.$token.'?customerId='.$customerId) }}" class="btn">Reset Your Password</a>
            <p>If you did not request a password reset, please ignore this email or reply to let us know. This password reset is only valid for the next 60 minutes.</p>
        </div>
        <div class="footer">
            <p>Thanks,<br>Your Company Team</p>
        </div>
    </div>
</body>
</html>
