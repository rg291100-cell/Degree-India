<!DOCTYPE html>
<html>

<head>
    <title>OTP Verification</title>
</head>

<body>
    <h2>Hello {{ $name }},</h2>
    <p>Your OTP code for verification is:</p>
    <h1 style="background: #f4f4f4; padding: 10px; display: inline-block;">{{ $otp }}</h1>
    <p>This OTP will expire in 10 minutes.</p>
    <p>If you didn't request this OTP, please ignore this email.</p>
    <br>
    <p>Thank you!</p>
</body>

</html>
