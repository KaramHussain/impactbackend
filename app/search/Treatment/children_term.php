<?php

namespace App\search\Treatment;


use App\search\Treatment\traits\likeScope;
use App\search\Treatment\traits\children_term_scopes\children_term_scopes;
use App\search\Treatment\{
                search,
                code,
                synonym,
                category,
                part,
                sub_category
};

class children_term extends search
{

    use likeScope,
        children_term_scopes;

    public function codes()
    {
        return $this->hasMany(code::class);
    }

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

    public function terms()
    {
        return $this->belongsToMany(term::class);
    }

    public function parts()
    {
        return $this->morphToMany(part::class, 'partable');
    }

}
