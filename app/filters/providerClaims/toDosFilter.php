<?php

namespace App\filters\providerClaims;

use App\filters\filtering;
use Illuminate\Database\Eloquent\Builder;

class toDosFilter extends filtering
{
    public function filter(Builder $builder, $value) 
    {
        $date = date('Y-m-d', strtotime($value))." 11:59:59";
        if(is_null($value)) return $builder;
        return $builder->where('date_of_service', '<=', $date);
    }

}