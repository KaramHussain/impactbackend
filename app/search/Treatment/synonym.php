<?php

namespace App\search\Treatment;

use App\search\Treatment\search;
use Illuminate\Database\Eloquent\Builder;

class synonym extends search
{

    public function related()
    {
        return $this->morphTo();
    }

    public function scopeLike(Builder $builder, $query, $related = 'term')
    {
        return $builder->where('name', 'LIKE', "%{$query}%")->where('related_type', $related);
    }

    public function scopeOrLike(Builder $builder, $query, $related = 'term')
    {
        return $builder->Orwhere('name', 'LIKE', "%{$query}%")->where('related_type', $related);
    }


}
