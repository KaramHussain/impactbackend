<?php

namespace App\preventiveCare;

use App\services;
use App\preventiveCare\preventiveCare;

class service_type extends preventiveCare
{
    protected $table = 'service_type';

    public function service()
    {
      return $this->belongsTo(services::class, 'service_id');
    }
}
