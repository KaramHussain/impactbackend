<?php

namespace App\doctors;

use Illuminate\Http\Request;
use App\doctors\{
                doctorTreatments,
                doctor_taxonomy_code,
                doctor_taxid,
                address,
                credential
            };
use App\manager\connectionManager;
use Illuminate\Database\Eloquent\Model;
use App\filters\doctors\doctorsFilters;
use Illuminate\Database\Eloquent\Builder;

class doctor extends Model
{

    protected $connection;
    protected $table = 'national_provider';
    protected $primaryKey = 'npi';

    protected $appends = [
        'doctor_taxonomy_codes',
        // 'doctor_address'
    ];


    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('mur');
    }

    public function treatments()
    {
        return $this->hasMany(doctorTreatments::class, 'npi');
    }

    public function scopeFilter(Builder $builder, Request $request, array $filters = [])
    {
        return  (new doctorsFilters($request))->add($filters)->filter($builder);
    }

    public function location()
    {
        return $this->address->zip_code;
    }

    public function findById($id)
    {
        return $this->where('id', $id)->first();
    }

    public function taxonomyCodes()
    {
        return $this->hasMany(doctor_taxonomy_code::class, 'npi');
    }

    public function taxonomyIds()
    {
        return $this->hasMany(doctor_taxid::class, 'npi');
    }

    public function address()
    {
       return $this->hasOne(address::class, 'provider_id');
    }

    public function creds()
    {
        return $this->belongsToMany(credential::class, 'provider_credentials', 'provider_id', 'credential_id');
    }

    public function getDoctorTaxonomyCodesAttribute()
    {
        return $this->taxonomyCodes();
    }

    public function getDoctorAddressAttribute()
    {
        return $this->address;
    }

}
