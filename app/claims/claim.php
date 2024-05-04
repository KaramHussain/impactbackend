<?php

namespace App\claims;

use App\User;
use App\claims\{claim_treatment, claim_dx_pointer};
use App\doctors\doctor;
use App\insurance\patient_insurance;
use App\order;
use Illuminate\Database\Eloquent\Model;


class claim extends Model
{
    protected $fillable = [
        'claim_id',
        'order_id',
        'user_id',
        'provider_id',
        'patient_insurance_id',
        'date_of_service',
        'claim_status',
        'claim_time',
        'transaction_date',
        'transaction_time',
        'interchange_date',
        'interchange_time',
        'submitter_entity_identifier_code',
        'submitter_name',
        'submitter_contact_name',
        'submitter_communication_number',
        'receiver_entity_identifier_code',
        'receiver_name',
        'receiver_identification_code',
        'total_claim_charge_amount',
        'no_of_proc',
        'no_of_dx'
    ];


    protected $appends = [
        'doctor'
    ];

    protected $with = [
        'order',
        'order.insurance',
        'order.checkout',
        'order.paymentMethod'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(order::class);
    }

    public function insurance()
    {
        return $this->belongsTo(patient_insurance::class);
    }

    public function treatments()
    {
        return $this->hasMany(claim_treatment::class);
    }

    public function pointers()
    {
        return $this->hasMany(claim_dx_pointer::class);
    }

    public function getDoctorAttribute()
    {
        return doctor::where('id', $this->provider_id)->first();
    }

    public function appendModel($model)
    {
        $this->with []= $model;
    }

}
