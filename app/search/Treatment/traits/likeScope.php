<?php

namespace App\search\Treatment\traits;

use Illuminate\Database\Eloquent\Builder;

trait likeScope
{
    public function scopeLike(Builder $builder, $query)
    {
        return $builder->where('name', 'LIKE', "%{$query}%");
    }

    public function scopeOrLike(Builder $builder, $query)
    {
        return $builder->Orwhere('name', 'LIKE', "%{$query}%");
    }
}
