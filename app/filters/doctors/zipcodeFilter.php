<?php

namespace App\filters\doctors;

use App\filters\filtering;
use Illuminate\Database\Eloquent\Builder;

class zipcodeFilter extends filtering
{
    public function filter(Builder $builder, $value)
    {
        if($value == null)
        {
            return $builder;
        }

        return $builder->where('zip_code', $value);
    }

}
