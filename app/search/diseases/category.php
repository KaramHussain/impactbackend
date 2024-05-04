<?php

namespace App\search\diseases;

use App\search\diseases\search;
use App\search\diseases\{sub_category, icd_mapping};

class category extends search
{

    public function sub_categories()
    {
        return $this->hasMany(sub_category::class);
    }

    public function terms()
    {
        return $this->hasMany(icd_mapping::class);
    }

}
