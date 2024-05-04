<?php

namespace App\filters\providerClaims;

use App\filters\filtering;
use Illuminate\Database\Eloquent\Builder;

class fromDosFilter extends filtering
{
    public function filter(Builder $builder, $value) 
    {
        $date = date('Y-m-d', strtotime($value))." 00:00:00";
        if(is_null($value)) return $builder;
        return $builder->where('date_of_service', '>=', $date);
    }

}