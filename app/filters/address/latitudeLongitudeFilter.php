<?php

namespace App\filters\address;

use App\filters\filtering;
use Illuminate\Database\Eloquent\Builder;

class latitudeLongitudeFilter extends filtering
{
    public function filter(Builder $builder, $value)
    {
        if($value == null || !strpos($value, ',')) return $builder;

        $latlng = explode(",", $value);

        $latitude = $latlng[0];
        $longitude = $latlng[1];

        $max_distance = 5;
        $min_distance = 0;

        return $builder::where(`(6371*acos( cos( radians($latitude) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( latitude) ) ) ) AS distance  FROM address HAVING (distance IS NULL OR (distance >= $min_distance AND distance <= $max_distance))`);
    }
}
