<?php

namespace App\search\diseases;

use App\search\diseases\{search, category, icd_mapping};

class sub_category extends search
{

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function icds()
    {
        return $this->hasMany(icd_mapping::class);
    }

}
