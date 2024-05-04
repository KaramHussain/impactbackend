<?php

namespace App\filters\treatments;

use App\filters\filtering;
use Illuminate\Database\Eloquent\Builder;

class treatmentFilter extends filtering
{

    public function filter(Builder $builder, $value)
    {
        if($value == null) return $builder;

        return $builder->where('all_codes', $value);
    }

}
