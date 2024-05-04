<?php

namespace App\filters;

use Illuminate\Database\Eloquent\Builder;

abstract class filtering
{
    abstract public function filter(Builder $builder, $value);

    public function mappings()
    {
        return [];
    }

    public function sorts() 
    {
        return [];
    }

    public function resolveFilterValue($value)
    {
        if(is_array($value)) 
        {
            return $value;
        }
        return isset($this->mappings()[$value]) ? $this->mappings()[$value] : null;
    }

    public function resolveOrderValue()
    {
        return request()->has('order_by') && isset($this->sorts()[request()->order_by])
        ? $this->sorts()[request()->order_by]
        : 'desc';
    }



}
