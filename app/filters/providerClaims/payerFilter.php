<?php

namespace App\filters\providerClaims;

use App\filters\filtering;
use Illuminate\Database\Eloquent\Builder;
use App\carepays_providers\provider_claim;

class payerFilter extends filtering
{
    public function mappings()
    {
       return array_filter(provider_claim::pluck('payer_id')->unique()->toArray());
    }

    public function filter(Builder $builder, $value) 
    {
        $value = gettype($value) == 'string' ? json_decode($value) : $value;
        $value = $this->resolveFilterValue($value);
        if(is_null($value)) return $builder;
        return is_array($value) 
        ? $builder->whereIn('payer_id', $value) 
        : $builder->where('payer_id', $value);
    }

}