<?php

namespace App\search\diseases;

use App\search\diseases\{search, icd10cm, docdoc_layterm};


class cpts_layterm extends search
{

    public function icds()
    {
        return $this->belongsToMany(icd10cm::class, 'icd_cpts_crosswalk', 'cpt_id', 'icd_id', 'cpt_code', 'icd10cm_code');
    }

    public function docdoc_layterms()
    {
        return $this->hasOne(docdoc_layterm::class, 'cpt');
    }

}
