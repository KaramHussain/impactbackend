<?php

namespace App\preventiveCare;

use Illuminate\Database\Eloquent\Model;

class preventiveCare extends Model
{
    protected $connection;

    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('preventive_care');
    }

}
