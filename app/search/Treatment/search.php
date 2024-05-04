<?php

namespace App\search\Treatment;

use App\manager\connectionManager;
use Illuminate\Database\Eloquent\Model;

class search extends Model
{
    public function getConnectionName()
    {
        return app(connectionManager::class)->getConnection('search_engine');
    }
}
