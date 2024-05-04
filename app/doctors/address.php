<?php

namespace App\doctors;

use App\doctors\doctor;
use Illuminate\Http\Request;
use App\manager\connectionManager;
use App\filters\address\addressFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class address extends Model
{
    protected $connection;
    protected $table = 'address';

    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('mur');
    }

    public function scopeFilter(Builder $builder, Request $request, array $filters = [])
    {
        return ((new addressFilters($request))->add($filters)->filter($builder));
    }

    public function doctor()
    {
        $this->belongsTo(doctor::class, 'provider_id');
    }

}
