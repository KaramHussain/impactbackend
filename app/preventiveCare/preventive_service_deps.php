<?php

namespace App\preventiveCare;


use App\{excludes, questions};
use App\preventiveCare\preventiveCare;

class preventive_service_deps extends preventiveCare
{

    protected $table = 'preventive_service_deps';


    public function questions()
    {
       return $this->hasMany(questions::class, 'code_id');
    }

    public function frequency()
    {
      return $this->belongsTo(frequency::class, 'frequency_id');
    }

    public function excludes()
    {
      return $this->belongsTo(excludes::class, 'exclude_id');
    }

}
