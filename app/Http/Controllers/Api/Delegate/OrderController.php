<?php

namespace App\Http\Controllers\Api\Delegate;

use App\Enums\OrderStatus;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Services\Delegate\OrderFilterService;
use App\Http\Resources\Api\Delegate\OrdersResource;
use App\Http\Requests\Api\Delegate\FilterOrdersRequest;
use App\Models\RejectedOrders;

class OrderController extends Controller
{
    use HttpResponses;
    public function filterOrders(FilterOrdersRequest $request)
    {
        $request->validated();
        $status = $request->query('status');
        $delegate = auth('delegate')->user();
        $orders = (new OrderFilterService())->filterOrdersForDelegate($delegate, $status);

        return $this->successWithDataResponse(OrdersResource::collection($orders));
    }

    public function showOrderDetails($id)
    {
        //TODO: 
        $order = auth('delegate')->user()->orders()->find($id);
        if (!$order) {
            return $this->failureResponse('Order not found');
        }
        return $this->successWithDataResponse(new OrdersResource($order));
    }

    public function acceptOrder($id)
    {

        $order = auth('delegate')->user()->orders()->find($id);
        if (!$order || $order->status != 0) {
            return $this->failureResponse('الطلب غير موجود أو تم قبوله مسبقاً');
        }
        $order->update(['status' => OrderStatus::WAITING->value]);
        return $this->successResponse('تم قبول الطلب بنجاح');
    }

    public function rejectOrder($id)
    {

        $order = auth('delegate')->user()->orders()->find($id);
        if (!$order || $order->status != 0) {
            return $this->failureResponse('الطلب غير موجود أو تم قبوله مسبقاً');
        }
        $order->update(['delegate_id' => null]);
        RejectedOrders::create(['order_id' => $order->id, 'delegate_id' => auth('delegate')->user()->id,]);
        return $this->successResponse('تم رفض الطلب بنجاح');
    }

    public function startRide($id)
    {
        $order = auth('delegate')->user()->orders()->find($id);
        if (!$order || $order->status != 1) {
            return $this->failureResponse('الطلب غير موجود أو تم بدء الرحلة مسبقاً');
        }
        $order->update(['status' => OrderStatus::SHIPPING->value]);
        return $this->successResponse('تم بدء الرحلة بنجاح');
    }
    public function completeOrder($id)
    {
        $order = auth('delegate')->user()->orders()->find($id);
        if (!$order || $order->status != 2) {
            return $this->failureResponse('الطلب غير موجود أو تم إكماله مسبقاً');
        }
        $order->update(['status' => OrderStatus::DELIVERED->value]);
        return $this->successResponse('تم إكمال الطلب بنجاح');
    }
}
