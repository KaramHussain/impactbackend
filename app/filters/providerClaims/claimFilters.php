<?php

namespace App\filters\providerClaims;

use App\filters\providerClaims\sorts\claimSorts;
use App\filters\filtersAbstract;
use App\filters\providerClaims\{
    statusFilter, 
    claimStatusFilter, 
    fromDosFilter,
    toDosFilter,
    payerFilter
};



class claimFilters extends filtersAbstract
{
    protected $filters = [
        'status'       => statusFilter::class,
        'eob_response' => claimStatusFilter::class,
        'from'         => fromDosFilter::class,
        'to'           => toDosFilter::class,  
        'sort_by'      => claimSorts::class,
        'payers'       => payerFilter::class 
    ];
}
