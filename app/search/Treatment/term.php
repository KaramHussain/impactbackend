<?php

namespace App\search\Treatment;

use App\search\Treatment\{search, synonym, children_term, category, sub_category};
use App\search\Treatment\traits\likeScope;
use Illuminate\Database\Eloquent\Builder;

class term extends search
{

    use likeScope;

    public function synonyms()
    {
        return $this->morphMany(synonym::class, 'related');
    }

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(sub_category::class);
    }

    public function children_terms()
    {
        return $this->belongsToMany(children_term::class);
    }

    public function parts()
    {
        return $this->morphToMany(part::class, 'partable');
    }

    public function codes()
    {
        return $this->belongsToMany(code::class);
    }

    public function scopeSubqueryIds(Builder $builder, $query)
    {
        return $builder->select('id')->where('name', 'LIKE', "%{$query}%");
    }
}
