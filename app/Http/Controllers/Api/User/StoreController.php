<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Store;
use App\Models\Product;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\User\Home\BestStoresResource;
use App\Http\Resources\Api\User\Home\DetailedStoreResource;
use App\Http\Resources\Api\User\Home\ProductDetailsResource;
use App\Http\Resources\Api\User\Home\ProductResource;
use App\Http\Resources\Api\User\Home\StoresByCategoryResource;

class StoreController extends Controller
{
    use HttpResponses;

    public function getStoreByCategory($categoryId)
    {
        $stores = Store::active()->where('category_id', $categoryId)
        ->searchByName(request()->input('name'))->get(['id', 'name', 'image']);
        return $this->successWithDataResponse(StoresByCategoryResource::collection($stores));
    }

    public function bestStores()
    {
        $stores = Store::active()->orderBy('rating', 'desc')->take(10)->get();
        return $this->successWithDataResponse(BestStoresResource::collection($stores));
    }

    public function getStoreById($storeId)
    {
        $store = Store::where('id', $storeId)->first();
        return $this->successWithDataResponse(new DetailedStoreResource($store));
    }

    public function getProductsByCategory($categoryId)
    {
        $products = Product::active()->where('product_category_id', $categoryId)->get(['id','name','image','price']);
        return $this->successWithDataResponse(ProductResource::collection($products));
    }

    public function productById($productId)
    {
        $product = Product::where('id', $productId)->first();
        if (!$product) {
            return $this->failureResponse('المنتج غير موجود');
        }
        return $this->successWithDataResponse(new ProductDetailsResource($product));
    }

    public function frequentProducts()
    {
        $products = Product::active()->where('is_frequent', true)->get(['id','name','image','price']);
        return $this->successWithDataResponse(ProductResource::collection($products));
    }
}
