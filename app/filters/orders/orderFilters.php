<?php

namespace App\filters\orders;

use App\filters\filtersAbstract;
use App\filters\orders\statusFilter;
use App\filters\orders\sorts\orderSorts;

class orderFilters extends filtersAbstract
{
    protected $filters = [
        'status'  => statusFilter::class,
        'sort_by' => orderSorts::class
    ];
}
