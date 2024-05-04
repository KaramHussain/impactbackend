<?php

namespace App\preventiveCare;

use App\service_type;
use App\preventiveCare\preventiveCare;

class services extends preventiveCare
{
    protected $table = 'service';

    public function definition()
    {
      return $this->hasMany(service_definition::class, 'service_id');
    }

    public function cpts()
    {
      return $this->hasMany(preventive_services_deps::class);
    }

    public function types()
    {
      return $this->hasMany(service_type::class);
    }
}
