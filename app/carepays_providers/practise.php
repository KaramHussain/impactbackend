<?php

namespace App\carepays_providers;

use App\carepays_providers\provider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class practise extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'zipcode',
        'county',
        'city',
        'state',
        'admin_email',
        'address'
    ];

    public function providers()
    {
        return $this->hasMany(provider::class);
    }

    public function scopeAdmin(Builder $builder, $email)
    {
        return $builder->where('admin_email', $email)->first();
    }
}
