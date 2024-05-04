<?php

namespace App\search\Treatment;

use App\search\Treatment\{
    search,
    sub_category,
    code,
    children_term,
    term
};
use App\search\Treatment\traits\likeScope;

class category extends search
{

    use likeScope;

    public function sub_categories()
    {
        return $this->hasMany(sub_category::class);
    }

    public function codes()
    {
        return $this->hasMany(code::class);
    }

    public function children_terms()
    {
        return $this->hasMany(children_term::class);
    }

    public function terms()
    {
        return $this->hasMany(term::class);
    }

    public function parts()
    {
        return $this->morphToMany(part::class, 'partable');
    }

}
