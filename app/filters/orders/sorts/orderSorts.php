<?php

namespace App\filters\orders\sorts;

use App\filters\filtering;
use Illuminate\Database\Eloquent\Builder;

class orderSorts extends filtering
{
    public function mappings()
    {
        return [
            'date'  => 'created_at',
            'dos'   => 'date_of_service',
            'total' => 'total'
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
        //default order by created_at desc
        if($value == null)
        {
            return $builder->orderBy('created_at', $this->resolveOrderValue());
        }

        return $builder->orderBy($value, $this->resolveOrderValue());
    }

}
