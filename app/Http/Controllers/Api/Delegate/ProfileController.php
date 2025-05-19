<?php

namespace App\Http\Controllers\Api\Delegate;

use App\Models\Order;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreFCMTokenRequest;
use App\Http\Requests\Api\Delegate\UpdateProfileRequest;
use App\Http\Resources\Api\Delegate\DelegateOrdersResource;
use App\Http\Resources\Api\Delegate\DelegateProfileResource;

class ProfileController extends Controller
{
    use HttpResponses;
    public function getProfile()
    {
        $delegate = Auth('delegate')->user();
        return $this->successWithDataResponse(new DelegateProfileResource($delegate));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $delegate = Auth('delegate')->user();

        $delegate->update($request->validated());

        return $this->successWithDataResponse(new DelegateProfileResource($delegate));
    }

    public function myOrders()
    {
        $orders = Order::where('delegate_id', Auth('delegate')->id())->get();
        return $this->successWithDataResponse(DelegateOrdersResource::collection($orders));
    }

    public function updateToken(StoreFCMTokenRequest $request)
    {
        $delegate = Auth('delegate')->user();

        $delegate->update($request->validated());

        return $this->successResponse('FCM token stored successfully');
    }

    public function getNotifications()
    {
        $delegate = auth('delegate')->user();

        $notifications = $delegate->notifications()->orderBy('created_at', 'desc')->get(['data']);

        if ($notifications->isEmpty()) {
            return $this->successResponse('لا يوجد إشعارات');
        }

        return $this->successWithDataResponse($notifications);
    }
}
