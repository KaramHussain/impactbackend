<?php

namespace App\rules;

use App\rules\part_code;
use App\rules\rules;

class part_range extends rules
{

    public function codes()
    {
        return $this->hasMany(part_code::class, 'range_id');
    }

}
