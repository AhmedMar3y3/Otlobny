<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Address;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Address\StoreAddressRequest;

class AddressController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $addresses = Address::where('user_id', auth()->id())->get(['id', 'title', 'map_desc', 'lng', 'lat']);
        return $this->successWithDataResponse($addresses);
    }

    public function store(StoreAddressRequest $request)
    {
        Address::create($request->validated() + ['user_id' => auth()->id()]);
        return $this->successResponse('تم إضافة العنوان بنجاح');
    }

    public function destroy($id)
    {
        $address = Address::find($id);
        if (auth()->user()->id == $address->user_id) {
            $address->delete();
            return $this->successResponse('تم حذف العنوان بنجاح');
        }
        return $this->failureResponse('غير مصرح لك بحذف هذا العنوان');
    }
}
