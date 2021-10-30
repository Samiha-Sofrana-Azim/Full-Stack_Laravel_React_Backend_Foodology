<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegistrationFormRequest;
use App\Jobs\ForgotPasswordJob;
use App\Jobs\VerifyEmailJob;
use App\Traits\ApiResponseWithHttpStatus;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponseWithHttpStatus;

    public function  __construct()
    {
        Auth::shouldUse('users');
    }

    public function register(RegistrationFormRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        $verify_token = Str::random(30);
        $data = ['access_token' => $token, 'user' => Auth::user()];
        $details = ['user' => $user, 'token' => $verify_token, 'email' => Crypt::encryptString($user->email)];
        if (dispatch(new VerifyEmailJob($details))) {
            $user->update([
                'verify_token' => $verify_token
            ]);
        }
        return $this->apiResponse('Registration Success !  please check your email to verify your account', $data, Response::HTTP_OK, true);
    }

    public  function login(LoginFormRequest $request)
    {

        $input = $request->only('email', 'password');
        JWTAuth::factory()->setTTL(10080);
        $user = User::where('email', $request->email)->first();
        if ($user->verified == false) {
            return $this->apiResponse('Unverified !, Verify your email first !', null, Response::HTTP_BAD_REQUEST, false);
        }

        if (!$token = JWTAuth::attempt($input)) {
            return $this->apiResponse('Invalid credential', null, Response::HTTP_BAD_REQUEST, false);
        }
        $data = ['access_token' => $token, 'user' => Auth::user()];
        return $this->apiResponse('Success Login', $data, Response::HTTP_OK, true);
    }


    public  function logout()
    {
        if (Auth::check()) {
            return $this->apiResponse('Logout Success', null, Response::HTTP_OK, true);
            $token = Auth::getToken();
            JWTAuth::setToken($token);
            JWTAuth::invalidate();
            Auth::logout();
        } else {
            return $this->apiResponse('Logout Error', null, Response::HTTP_UNAUTHORIZED, false);
        }
    }

    public function authenticatedUser()
    {
        $user = Auth::user();
        if ($user->verified == true) {
            return $this->apiResponse('Success !', Auth::user(), Response::HTTP_OK, true);
        } else {
            return $this->apiResponse('Unverified !, Verify your email first', null, Response::HTTP_OK, true);
        }
    }

    public function verified($token, $email)
    {
        $email = Crypt::decryptString($email);
        $user = User::where('email', $email)->first();
        if ($user->verify_token == $token) {
            $user->update([
                'verified' => true,
                'email_verified_at' => now(),
            ]);
            return response([
                'message' => "Verification Success !",
            ]);
        } else {
            return response([
                'message' => "Sorry your token is not valid ! Please verify from your dashboard",
            ]);
        }
    }

    public function forgotPassword(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if ($user->count() > 0) {
            $token = Str::random(30);
            $details = ['user' => $user, 'token' => $token, 'email' => Crypt::encryptString($user->email)];
            if (dispatch(new ForgotPasswordJob($details))) {
                $user->update([
                    'remember_token' => $token
                ]);
            }
            return $this->apiResponse('Reset password link has been sent to your email !', null, Response::HTTP_OK, true);
        } else {
            return $this->apiResponse('Invalid credential', null, Response::HTTP_BAD_REQUEST, false);
        }
    }

    public function forgotPasswordForm($token, $email)
    {
        $email = Crypt::decryptString($email);
        $user = User::where('email', $email)->first();
        if ($user->remember_token == $token) {
            return view('password.forgot', compact('user'));
        } else {
            return response([
                'message' => "Sorry ! your token is not valid",
            ]);
        }
    }

    public function forgotPasswordUpdate(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $update = $user->update([
            'password' => bcrypt($request->password)
        ]);
        if ($update) {
            return response([
                'message' => "Password Updated !",
            ]);
        } else {
            return response([
                'message' => "Something is wrong",
            ]);
        }
    }
}
