<?php

namespace App\search\Treatment;

use App\search\Treatment\{search, code, term, children_term, category, sub_category};
use App\search\Treatment\traits\likeScope;
use Illuminate\Database\Eloquent\Builder;

class part extends search
{
    use likeScope;

    public function codes()
    {
        return $this->morphedByMany(code::class, 'partable');
    }

    public function categories()
    {
        return $this->morphedByMany(category::class, 'partable');
    }

    public function sub_categories()
    {
        return $this->morphedByMany(sub_category::class, 'partable');
    }

    public function terms()
    {
        return $this->morphedByMany(term::class, 'partable');
    }

    public function children_terms()
    {
        return $this->morphedByMany(children_term::class, 'partable');
    }

    public function scopeSubqueryIds(Builder $builder, $query)
    {
        return $builder->select('id')->where('name', 'like', "%{$query}%");
    }

}
