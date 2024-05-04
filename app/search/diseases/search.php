<?php

namespace App\search\diseases;

use App\manager\connectionManager;
use Illuminate\Database\Eloquent\Model;

class search extends Model
{
    public function getConnectionName()
    {
        return app(connectionManager::class)->getConnection('icd10cm_cpts_layterms_crosswalk');
    }
}
