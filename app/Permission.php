<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public function scopeAllGranted(Builder $builder)
    {
        return $builder->where('name', 'all-permissions')->first();
    }
}
