<?php

namespace App\Services\Home;

use App\Models\Store;
use Illuminate\Support\Facades\DB;

class StoreService
{
    public function getClosestStores($lat, $lng, $limit = 10)
    {
        return Store::select(
            'id',
            'name',
            'image',
            'rating',
            'delivery_time_min',
            'delivery_time_max',
            DB::raw("ST_Distance_Sphere(point(lng, lat), point($lng, $lat)) as distance")
        )
        ->where('is_active', true)
        ->orderBy('distance')
        ->limit($limit)
        ->get();
    }
}