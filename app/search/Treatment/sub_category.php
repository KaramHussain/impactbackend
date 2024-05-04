<?php

namespace App\search\Treatment;

use App\search\Treatment\{search, category, code, term, children_term};
use App\search\Treatment\traits\likeScope;

class sub_category extends search
{
    use likeScope;

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function parts()
    {
        return $this->morphToMany(part::class, 'partable');
    }

    public function terms()
    {
        return $this->hasMany(term::class);
    }

    public function children_terms()
    {
        return $this->hasMany(children_term::class);
    }

    public function codes()
    {
        return $this->hasMany(code::class);
    }

}
