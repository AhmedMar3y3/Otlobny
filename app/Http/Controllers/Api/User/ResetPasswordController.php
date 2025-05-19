<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ResetPassword\ResetPasswordRequest;
use App\Http\Requests\Api\User\ResetPassword\ResetPasswordSendCodeRequest;
use App\Http\Requests\Api\User\ResetPassword\ResetPasswordCheckCodeRequest;

class ResetPasswordController extends Controller
{
    use HttpResponses;
    public function sendCode(ResetPasswordSendCodeRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        $user->sendVerificationCode();

        return $this->successResponse();
    }

    public function checkCode(ResetPasswordCheckCodeRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->code !== $request->code) {
            return $this->failureResponse('كود غير صحيح');
        }

        if ($user->isCodeExpired()) {
            return $this->failureResponse('كود منتهي الصلاحية');
        }

        $user->update([
            'is_verified'   => true,
        ]);

        return $this->successResponse();
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->code !== $request->code) {
            return $this->failureResponse('كود غير صحيح');
        }

        if (! $user->is_verified) {
            return $this->failureResponse('يرجي ارسال كود التفعيل');
        }

        $user->updatePassword($request->password);

        return $this->successResponse('تم تغيير كلمة المرور بنجاح');
    }
}
