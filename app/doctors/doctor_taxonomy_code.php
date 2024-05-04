<?php

namespace App\doctors;

use App\doctors\doctor;
use App\manager\connectionManager;
use Illuminate\Database\Eloquent\Model;

class doctor_taxonomy_code extends Model
{
    protected $connection;
    protected $table = 'national_provider_taxonomy_codes';

    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('mur');
    }

    public function doctor()
    {
        return $this->belongsTo(doctor::class, 'npi');
    }
}
