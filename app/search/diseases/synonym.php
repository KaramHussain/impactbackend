<?php

namespace App\search\diseases;

use App\search\diseases\search;

class synonym extends search
{
    public function related()
    {
        return $this->morphTo();
    }
}
