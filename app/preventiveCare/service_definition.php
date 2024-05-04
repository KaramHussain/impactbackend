<?php

namespace App\preventiveCare;

use App\services;
use App\preventiveCare\preventiveCare;

class service_definition extends preventiveCare
{
    protected $table = 'service_definition';

    public function services()
    {
      return $this->belongsTo(services::class);
    }
}
