<!DOCTYPE html>
<html>
<head>
    <title>EXAM REGISTRATION</title>
</head>
<body>
<p>Hello {{ $details['name']??0 }},</p>

<p>Here is your OTP {{ $details['OTP']??1 }}</p>

<p>Thank You</p>
</body>
</html>
