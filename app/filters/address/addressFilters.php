<?php

namespace App\filters\address;

use App\filters\filtersAbstract;
use App\filters\address\addressFilter;
use App\filters\address\latitudeLongitudeFilter;

class addressFilters extends filtersAbstract
{
    protected $filters = [
        'lat-lng' => latitudeLongitudeFilter::class,
        'address' => addressFilter::class
    ];
}
