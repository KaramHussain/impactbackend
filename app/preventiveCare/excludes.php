<?php

namespace App\preventiveCare;

use App\preventive_service_deps;
use App\preventiveCare\preventiveCare;

class excludes extends preventiveCare
{
    protected $table = 'excludes';

    public function cpts()
    {
      return $this->hasMany(preventive_service_deps::class, 'exclude_id');
    }

}
