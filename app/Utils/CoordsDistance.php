<?php

namespace App\Utils;

trait CoordsDistance
{
    public function calculateCoordinatesAtDistance($lat, $lon, $distance, $bearing)
    {
        $earthRadius = 6371;

        $lat     = deg2rad($lat);
        $lon     = deg2rad($lon);
        $bearing = deg2rad($bearing);

        $newLat = asin(sin($lat) * cos($distance / $earthRadius) +
            cos($lat) * sin($distance / $earthRadius) * cos($bearing));

        $newLon = $lon + atan2(sin($bearing) * sin($distance / $earthRadius) * cos($lat),
                cos($distance / $earthRadius) - sin($lat) * sin($newLat));

        return [
            'latitude'  => rad2deg($newLat),
            'longitude' => rad2deg($newLon)
        ];
    }
}