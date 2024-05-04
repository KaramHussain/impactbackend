<?php

namespace App\filters\treatments;

use App\filters\treatments\{treatmentFilter};
use App\filters\filtersAbstract;

class treatmentFilters extends filtersAbstract
{
    protected $filters = [
        'code' => treatmentFilter::class
    ];
}
