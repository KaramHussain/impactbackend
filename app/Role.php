<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    public function scopeAdmin(Builder $builder)
    {
        return $builder->where('name', 'admin')->first();
    }
}
