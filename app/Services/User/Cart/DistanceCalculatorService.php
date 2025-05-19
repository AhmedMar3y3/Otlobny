<?php

namespace App\Services\User\Cart;

class DistanceCalculatorService
{
    const EARTH_RADIUS = 6371;

    public function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);
        $lat2 = deg2rad($lat2);
        $lng2 = deg2rad($lng2);

        $deltaLat = $lat2 - $lat1;
        $deltaLng = $lng2 - $lng1;

        $a = sin($deltaLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($deltaLng / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return self::EARTH_RADIUS * $c;
    }
}