<?php

namespace App\Http\Controllers\Api\Delegate;

use App\Models\Admin;
use App\Models\Delegate;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Delegate\LoginRequest;
use App\Http\Requests\Api\Delegate\VerifyRequest;
use App\Http\Requests\Api\Delegate\RegisterRequest;
use App\Http\Requests\Api\Delegate\ResendCodeRequest;
use App\Http\Resources\Api\Delegate\DelegateResource;
use App\Http\Requests\Api\Delegate\ResetPasswordRequest;
use App\Http\Requests\Api\Delegate\StoreLocationRequest;
use App\Http\Requests\Api\Delegate\ResetPasswordSendCodeRequest;
use App\Http\Requests\Api\Delegate\ResetPasswordCheckCodeRequest;

class AuthController extends Controller
{
    use HttpResponses;
     public function register(RegisterRequest $request)
    {
        Admin::where('code', $request->admin_code)->first();
        $delegate = Delegate::create($request->validated());
        $delegate->sendVerificationCode();
        return $this->successWithDataResponse(new DelegateResource($delegate));
    }

    // Verify email
    public function verifyEmail(VerifyRequest $request)
    {
        $delegate = Delegate::where('phone', $request->phone)->first();

        if (!$delegate) {
            return $this->failureResponse('المستخدم غير موجود');
        }

        if ($delegate->code !== $request->code) {
            return $this->failureResponse('كود غير صحيح');
        }


        $delegate->markAsVerified();
        return $this->successWithDataResponse(DelegateResource::make($delegate)->setToken($delegate->login()));
    }


    // Resend verification code
    public function resendCode(ResendCodeRequest $request)
    {
        $delegate = Delegate::where('phone', $request->phone)->first();

        if (!$delegate) {
            return $this->failureResponse('المستخدم غير موجود');
        }

        $delegate->sendVerificationCode();
        return $this->successResponse();
    }

    public function setLocation(StoreLocationRequest $request)
    {
        $delegate = Auth('delegate')->user();
        return $this->successWithDataResponse(DelegateResource::make($delegate)->setToken(ltrim($request->header('authorization'), 'Bearer ')));
    }

    //Login delegate
    public function login(LoginRequest $request)
    {
        $delegate = Delegate::where('phone', $request->phone)->first();

        if (!$delegate || !Hash::check($request->input('password'), $delegate->password)) {
            return $this->failureResponse('بيانات الدخول غير صحيحة');
        }

        if (!$delegate->is_active) {
            return $this->inactiveUserResponse(new delegateResource($delegate));
        }

        $token = $delegate->login();

        if (!$delegate->completed_info) {
            return $this->incompletedUserResponse(DelegateResource::make($delegate)->setToken($token));
        }

        return $this->successWithDataResponse(delegateResource::make($delegate)->setToken($token));
    }
    //Logout delegate
    public function logout()
    {
        Auth::logout();
        return $this->successResponse('تم تسجيل الخروج بنجاح');
    }

    public function sendCode(ResetPasswordSendCodeRequest $request){
        $delegate = Delegate::where('email', $request->email)->first();

        $delegate->sendVerificationCode();

        return $this->successResponse();
    }

    public function checkCode(ResetPasswordCheckCodeRequest $request){
        $delegate = Delegate::where('email', $request->email)->first();

        if ($delegate->code !== $request->code) {
            return $this->failureResponse('كود غير صحيح');
        }

        $delegate->update([
            'is_verified'   => true,
        ]);

        return $this->successResponse();
    }

    public function resetPassword(ResetPasswordRequest $request){
        $delegate = Delegate::where('email', $request->email)->first();

        if ($delegate->code !== $request->code) {
            return $this->failureResponse('كود غير صحيح');
        }

        if (! $delegate->is_verified){
            return $this->failureResponse('يرجي ارسال كود التفعيل');
        }

        $delegate->updatePassword($request->password);

        return $this->successResponse('تم تغيير كلمة المرور بنجاح');
    }
}
