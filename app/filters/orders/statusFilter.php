<?php

namespace App\filters\orders;

use App\filters\filtering;
use Illuminate\Database\Eloquent\Builder;

class statusFilter extends filtering
{
    public function mappings()
    {
        return [
            'complete'       => 'complete',
            'payment-failed' => 'payment_failed',
            'processing'     => 'processing'
        ];
    }

    public function filter(Builder $builder, $value)
    {

        $value = $this->resolveFilterValue($value);

        if($value == null) return $builder;

        $builder->where('order_status', $value);

    }
}
