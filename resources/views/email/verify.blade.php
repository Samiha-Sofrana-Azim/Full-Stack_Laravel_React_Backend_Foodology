<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2 style="color:blue;">Email Verification Link</h2>
    <h2>Dear <span style="color: rgb(96, 9, 136);">{{ $details['user']->name }}</span> ,</h2>
    <p>Please click bellow link to verify your email</p>
    <h1><a href="http://127.0.0.1:8000/verify/{{$details['token']}}/{{$details['email']}}" style="margin-top: 5px;margin-bottom: 5px;color:red">Verify</a></h1>
    <p style="color: blue">Thank You!!!</p>
    <a href="http://localhost:3000/login" style="color: blue">Go to website</a>
</body>
</html>
