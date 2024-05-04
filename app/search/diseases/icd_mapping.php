<?php

namespace App\search\diseases;

use App\search\diseases\{search, icd10cm, category, sub_category};

class icd_mapping extends search
{

    protected $table = 'icd10cm_mapping';

    public function icd()
    {
        return $this->belongsTo(icd10cm::class, 'icd_id');
    }

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(sub_category::class);
    }

}
