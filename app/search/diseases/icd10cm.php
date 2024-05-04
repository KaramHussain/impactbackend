<?php

namespace App\search\diseases;

use App\search\diseases\{search, icd_mapping, cpts_layterm, synonym};

class icd10cm extends search
{
    protected $table = 'icd10cm';

    public function mapping()
    {
        return $this->hasOne(icd_mapping::class, 'icd_id');
    }

    public function cpts()
    {
        return $this->belongsToMany(cpts_layterm::class, 'icd_cpts_crosswalk', 'icd_id', 'cpt_id', 'icd10cm_code', 'cpt_code');
    }

    public function synonyms()
    {
        return $this->morphMany(synonym::class, 'related');
    }
}
