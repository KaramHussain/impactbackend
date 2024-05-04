<?php

namespace App\doctors;

use App\doctors\doctor;
use App\manager\connectionManager;
use Illuminate\Database\Eloquent\Model;

class credential extends Model
{
    protected $connection;

    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('mur');
    }

    public function doctor()
    {
        return $this->belongsToMany(doctor::class, 'provider_credentials', 'credential_id', 'provider_id');
    }

}
