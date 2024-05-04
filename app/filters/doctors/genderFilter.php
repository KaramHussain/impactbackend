<?php

namespace App\filters\doctors;

use App\filters\filtering;
use Illuminate\Database\Eloquent\Builder;

class genderFilter extends filtering
{
    public function mappings()
    {
        return [
            'm' => 'M',
            'f' => 'F'
        ];
    }
    public function filter(Builder $builder, $value)
    {
        $value = $this->resolveFilterValue($value);
        if($value == null)
        {
            return $builder;
        }
        return $builder->where('gender', $value);
    }
}
