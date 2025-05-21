<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\OrderStatus;
use App\Http\Resources\Api\User\Order\Profile\OrdersResource;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Api\User\ProfileResource;
use App\Http\Requests\Api\User\LocationRequest;
use App\Http\Requests\Api\User\Profile\DeleteAccountRequest;
use App\Http\Requests\Api\User\Profile\UpdateProfileRequest;
use App\Http\Requests\Api\User\Profile\EnableNotificationsRequest;


use App\Http\Requests\Api\User\Profile\ChangePasswordRequest;

class ProfileController extends Controller
{
    //TODO: make myorders function
    use HttpResponses;
    public function getProfile()
    {
        $user = auth()->user();
        return $this->successWithDataResponse(new ProfileResource($user));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $user->update($request->validated());

        return $this->successWithDataResponse(new ProfileResource($user));
    }

    public function deleteAccount(DeleteAccountRequest $request)
    {
        $user = Auth::user();
        if (!$user->verifyPassword($request->password)) {
            return $this->failureResponse('كلمة المرور غير صحيحة');
        }

        if ($user->hasNoOrdersOrCompletedOrders()) {
            $user->delete();
            return $this->successResponse('تم حذف الحساب بنجاح');
        }

        return $this->failureResponse('لديك طلبات لم يتم توصيلها بعد لا يمكن حذف الحساب');
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (!$user->verifyPassword($request->old_password)) {
            return $this->failureResponse('كلمة المرور القديمة غير صحيحة');
        }
        $user->changePassword($request->password);

        return $this->successResponse('تم تغيير كلمة المرور بنجاح');
    }

    public function updateLocation(LocationRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());
        return $this->successWithDataResponse(new ProfileResource($user));
    }

    public function exportReferralCode()
    {
        $user = Auth::user();
        return $this->successWithDataResponse($user->referral_code);
    }

    public function enableNotifications(EnableNotificationsRequest $request)
    {
        Auth::user()->update($request->validated() + ['is_notify' => true]);
        return $this->successResponse('تم تفعيل الاشعارات بنجاح');
    }

    public function myCompletedOrders()
    {
        $orders = auth()->user()->orders()->where('status', OrderStatus::DELIVERED->value)->get();
        return $this->successWithDataResponse(OrdersResource::collection($orders));
    }

    public function myPendingOrders()
    {
        $orders = auth()->user()->orders()->whereIn('status', [
            OrderStatus::WAITING->value,
            OrderStatus::PREPARING->value,
            OrderStatus::SHIPPING->value
        ])->get();

        return $this->successWithDataResponse(OrdersResource::collection($orders));
    }
}
