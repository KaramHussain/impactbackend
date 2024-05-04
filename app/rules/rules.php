<?php

namespace App\rules;

use App\manager\connectionManager;
use Illuminate\Database\Eloquent\Model;

class rules extends Model
{
    protected $connection;

    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('rules');
    }
}
