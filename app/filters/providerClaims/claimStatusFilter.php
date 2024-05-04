<?php

namespace App\filters\providerClaims;

use App\filters\filtering;
use Illuminate\Database\Eloquent\Builder;

class claimStatusFilter extends filtering
{

    public function mappings() 
    {
        return [
            'denied'     => 'denied',
            'accepted'   => 'accepted',
            'rejected'   => 'rejected',
            'processing' => 'processing'
        ];
    }

    public function filter(Builder $builder, $value) 
    {
        $value = $this->resolveFilterValue($value);
        if(is_null($value)) return $builder;
        return is_array($value)
        ? $builder->whereIn('claim_status', $value)
        : $builder->where('claim_status', $value);
    }

}