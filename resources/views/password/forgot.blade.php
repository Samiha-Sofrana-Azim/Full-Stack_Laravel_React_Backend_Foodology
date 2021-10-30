<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>

</body>
</html>

<div class="container">
    <div class="row justify-content-center">
     <div class="form-group col-md-4 col-md-offset-5 align-center ">
        <h2 class="text-primary my-5 text-center">Log in</h2>
        <form action="{{ route('forgot.update') }}" method="post">
            @csrf
            <input type="text" name="email" value="{{ $user->email }}" hidden>

          <div class="md-form md-outline">
            <label data-error="wrong" data-success="right" for="newPass">New password</label>
            <input type="password" name="password" id="newPass" class="form-control">

          </div>

          <div class="md-form md-outline py-4">
            <label data-error="wrong" data-success="right" for="newPassConfirm">Confirm password</label>
            <input type="password" name="password_confirmation" id="newPassConfirm" class="form-control">

          </div>

          <button type="submit" class="btn btn-primary mb-4">Change password</button>

        </form>
     </div>
    </div>
   </div>
