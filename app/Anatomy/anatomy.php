<?php

namespace App\Anatomy;

use App\manager\connectionManager;
use Illuminate\Database\Eloquent\Model;

class anatomy extends Model
{
    public $connnection;
    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('anatomy');
    }
}
