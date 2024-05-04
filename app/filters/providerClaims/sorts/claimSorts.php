<?php

namespace App\filters\providerClaims\sorts;

use App\filters\filtering;
use Illuminate\Database\Eloquent\Builder;

class claimSorts extends filtering
{
    public function mappings()
    {
        return [
            'date'          => 'created_at',
            'dos'           => 'date_of_service',
            'total_charges' => 'total_claim_charges'
        ];
    }

    public function sorts()
    {
        return [
            'asc'     => 'asc',
            'desc'    => 'desc',
            'highest' => 'desc',
            'lowest'  => 'asc'
        ];
    }

    public function filter(Builder $builder, $value)
    {
        $value = $this->resolveFilterValue($value);
        if($value == null)
        {
            return $builder->orderBy('created_at', $this->resolveOrderValue());
        }
        return $builder->orderBy($value, $this->resolveOrderValue());
    }

}
