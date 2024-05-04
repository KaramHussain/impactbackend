<?php

namespace App\Http\Controllers\AnatomyController;

use App\Anatomy\body_part;
use App\Http\Controllers\AnatomyController\AnatomyController;

class BodyPartController extends AnatomyController
{

    public function fetch(array $parts, $param = 'name')
    {
        return body_part::whereIn($param, $parts)->pluck('id');
    }
}
