<?php

namespace App\Services\Auth;

use App\Notifications\sendVerifyCode;


class SendVerificationCodeService
{
    public function sendCodeToUser($user)
    {
        $user->notify(new sendVerifyCode($user->code));
    }
}