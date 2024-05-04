<?php

namespace App\preventiveCare;

use App\preventive_service_deps;
use App\preventiveCare\preventiveCare;

class frequency extends preventiveCare
{
    protected $table = "frequency";

    public function cpts()
    {
      return $this->hasMany(preventive_service_deps::class);
    }
}
