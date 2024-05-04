<?php

namespace App\doctors;

use App\manager\connectionManager;
use Illuminate\Database\Eloquent\Model;

class provider_type extends Model
{
    protected $connection;

    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('mur');
    }
}
