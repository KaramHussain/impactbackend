<?php

namespace App\filters\providerClaims;

use App\filters\filtering;
use Illuminate\Database\Eloquent\Builder;

class statusFilter extends filtering
{

    public function mappings() 
    {
        return [
            'assigned'       => 'assigned',
            'submitted'      => 'submitted',
            'resolved'       => 'resolved',
            'to_be_reviewed' => 'to_be_reviewed',
            'unpaid_claims'  => ['assigned', 'to_be_reviewed']
        ];
    }

    public function filter(Builder $builder, $value) 
    {
        $value = $this->resolveFilterValue($value);
        if(is_null($value)) return $builder;
        return is_array($value) 
        ? $builder->whereIn('status', $value) 
        : $builder->where('status', $value);
    }

}