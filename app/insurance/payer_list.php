<?php

namespace App\insurance;

use App\carepays_providers\provider;
use Illuminate\Database\Eloquent\Model;

class payer_list extends Model
{
    protected $table = 'payer_list';

    public function providers()
    {
        return $this->morphToMany(provider::class, 'responsable', 'provider_responsibility');
    }
}
