<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\Api\User\UserResource;
use App\Http\Requests\Api\User\LocationRequest;
use App\Http\Requests\Api\User\Auth\RegisterRequest;
use App\Http\Requests\Api\User\Auth\LoginUserRequest;
use App\Http\Requests\Api\User\Auth\ResendCodeRequest;
use App\Http\Requests\Api\User\Auth\VerifyUserRequest;
use App\Http\Requests\Api\User\Auth\GoogleLoginRequest;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    use HttpResponses;

    // Register user
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        $user->sendVerificationCode();

        return $this->successWithDataResponse(new UserResource($user));
    }

    // Verify email
    public function verifyEmail(VerifyUserRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->failureResponse('المستخدم غير موجود');
        }

        if ($user->code !== $request->code) {
            return $this->failureResponse('كود غير صحيح');
        }

        $user->markAsVerified();
        return $this->successWithDataResponse(UserResource::make($user)->setToken($user->login()));
    }


    // Resend verification code
    public function resendCode(ResendCodeRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->failureResponse('المستخدم غير موجود');
        }

        $user->sendVerificationCode();
        return $this->successResponse();
    }


    public function setLocation(LocationRequest $request)
    {
        $user = auth()->user();
        $user->updateLocation($request->validated());
        return $this->successWithDataResponse(UserResource::make($user)->setToken(ltrim($request->header('authorization'), 'Bearer ')));
    }
    //Login User
    public function login(LoginUserRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return $this->failureResponse('بيانات الدخول غير صحيحة');
        }

        if (!$user->is_active) {
            return $this->inactiveUserResponse(new UserResource($user));
        }

        $token = $user->login();

        if (!$user->completed_info) {
            return $this->incompletedUserResponse(UserResource::make($user)->setToken($token));
        }

        return $this->successWithDataResponse(UserResource::make($user)->setToken($token));
    }
    
    //Logout User
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse('تم تسجيل الخروج بنجاح');
    }

    // Google Sign-In
    public function googleLogin(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        try {
            $googleUser = Socialite::driver('google')->stateless()->userFromToken($request->token);
        } catch (\Exception $e) {
            return $this->failureResponse('رمز Google غير صالح');
        }

        $user = User::where('email', $googleUser->email)->first();

        if ($user) {
            if (!$user->is_active) {
                $user->update(['is_active' => true]);
            }
            $token = $user->login();
            if (!$user->completed_info) {
                return $this->incompletedUserResponse(UserResource::make($user)->setToken($token));
            }
            return $this->successWithDataResponse(UserResource::make($user)->setToken($token));
        } else {
            $newUser = User::create([
                'first_name' => $googleUser->user['given_name'] ?? 'Google',
                'last_name' => $googleUser->user['family_name'] ?? 'User',
                'email' => $googleUser->email,
                'password' => Hash::make(Str::random(16)),
                'is_active' => true,
                'completed_info' => false,
            ]);

            $token = $newUser->login();
            return $this->incompletedUserResponse(UserResource::make($newUser)->setToken($token));
        }
    }
}
