<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2 style="color: blue;">Forgot Password Link</h2>
    <h2>Dear <span style="color: blue;">{{ $details['user']->name }}</span> ,</h2>
    <p>Click this link to change your password</p>
    <h1><a href="http://127.0.0.1:8000/forgot/{{$details['token']}}/{{$details['email']}}" style="margin-top: 5px;margin-bottom: 5px;color:red">Reset Password</a></h1>
    <p style="color: blue">Thank You</p>
    <a href="http://localhost:3000/login" style="color: blue">Go to website</a>
</body>
</html>
