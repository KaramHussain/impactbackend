<?php

namespace App\filters\doctors;

use App\filters\doctors\{genderFilter, stateFilter, zipcodeFilter, credsFilter};
use App\filters\filtersAbstract;

class doctorsFilters extends filtersAbstract
{

    protected $filters = [
        'gender' => genderFilter::class,
        'state' => stateFilter::class,
        'zipcode'=> zipcodeFilter::class,
        'credentialed' => credsFilter::class
    ];
}
