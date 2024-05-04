<?php

namespace App\search\diseases;

use App\search\diseases\{search, cpts_layterm};

class docdoc_layterm extends search
{
    public function cpt()
    {
        return $this->belongsTo(cpts_layterm::class, 'cpt');
    }
}
