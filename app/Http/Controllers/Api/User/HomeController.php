<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Store;
use App\Models\Banner;
use App\Models\Category;
use App\Traits\HttpResponses;
use App\Services\Home\StoreService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\Home\CategoryResource;
use App\Http\Requests\Api\User\Home\ClosestStoresRequest;
use App\Http\Resources\Api\User\Home\ClosestStoreResource;
use App\Http\Resources\Api\User\Home\StoresWithOffersResource;

class HomeController extends Controller
{
    use HttpResponses;
    protected $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function searchForStores()
    {
        $stores = Store::where('name', 'like', '%' . request('search') . '%')
            ->get(['id', 'name', 'image', 'rating']);

        if ($stores->isEmpty()) {
            return $this->failureResponse('لا توجد متاجر بهذا الاسم');
        }

        return $this->successWithDataResponse($stores);
    }

    public function banners()
    {
        $banners = Banner::get(['id', 'image']);
        return $this->successWithDataResponse($banners);
    }
    public function categories()
    {
        $categories = Category::get(['id', 'name', 'image']);
        if ($categories->isEmpty()) {
            return $this->failureResponse('لا توجد فئات');
        }
        return $this->successWithDataResponse(CategoryResource::collection($categories));
    }


    public function latestStoresWithOffers()
    {
        $stores = Store::whereHas('products', function ($query) {
            $query->where('has_discount', 1);
        })
            ->latest()
            ->take(10)
            ->get(['id', 'name', 'image', 'rating']);

        return $this->successWithDataResponse(StoresWithOffersResource::collection($stores));
    }

    public function closestStores(ClosestStoresRequest $request)
    {
        $lat = $request->lat;
        $lng = $request->lng;
        $stores = $this->storeService->getClosestStores($lat, $lng);
        return ClosestStoreResource::collection($stores);
    }
}
