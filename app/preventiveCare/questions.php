<?php

namespace App\preventiveCare;

use App\preventive_service_deps;
use App\preventiveCare\preventiveCare;

class questions extends preventiveCare
{
    protected $table = 'questions';

    public function cpts()
    {
      return $this->belongsTo(preventive_service_deps::class);
    }
}
