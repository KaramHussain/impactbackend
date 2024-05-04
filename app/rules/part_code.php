<?php

namespace App\rules;

use App\rules\rules;
use App\rules\part_range;
use Illuminate\Support\Facades\DB;

class part_code extends rules
{

    public function range()
    {
        return $this->belongsTo(part_range::class, 'range_id');
    }

}
