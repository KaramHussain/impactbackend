<?php

namespace App;

use App\carepays_providers\provider;
use Illuminate\Database\Eloquent\Model;

class remark_code extends Model
{
    public function providers()
    {
        return $this->morphToMany(provider::class, 'responsable', 'provider_responsibility');
    }
}
