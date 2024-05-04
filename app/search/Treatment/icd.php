<?php

namespace App\search\Treatment;

use App\search\Treatment\{search, children_term, category, sub_category};
use Illuminate\Database\Eloquent\Builder;

class icd extends search
{

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(sub_category::class);
    }

    public function children_term()
    {
        return $this->belongsTo(children_term::class);
    }

    public function scopeLike(Builder $builder, $query)
    {
        return $builder->where('icd', 'LIKE', "{$query}%")->orWhere('definition', 'LIKE', "%{$query}%");
    }

    public function scopeOrLike(Builder $builder, $query)
    {
        return $builder->Orwhere('icd', 'LIKE', "{$query}%")->orWhere('definition', 'LIKE', "%{$query}%");
    }

}
