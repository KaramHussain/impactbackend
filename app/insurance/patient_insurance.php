<?php

namespace App\insurance;

use App\{User, order};
use App\claims\claim;
use App\dependants\patient_dependant;
use App\insurance\payer_list;
use Illuminate\Database\Eloquent\Model;

class patient_insurance extends Model
{

    protected $fillable = [
        'insurance_person',
        'insured_ssn',
        'insurance_package',
        'financial_guarantor_name',
        'insurance_name',
        'insurance_type',
        'insurance_policy_number',
        'insurance_service_number',
        'insurance_plan_name',
        'is_employeed',
        'can_contact_employer',
        'name_of_employer',
        'hr_contact_person',
        'hr_phone_no',
        'group_id_no'
    ];

    protected $appends = [
        'policy_number',
        'employer_name',
        'company_name',
        'guarantor',
        'plan_name',
        'person',
        'payer_id'
    ];

    protected $hidden = [
        'insurance_policy_number',
        'name_of_employer',
        'insurance_name',
        'financial_guarantor_name',
        'insurance_person',
        'insurance_plan_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dependants()
    {
        return $this->hasMany(patient_dependant::class, 'insurance_id');
    }

    public function order()
    {
        return $this->hasOne(order::class, 'insurance');
    }

    public function getPolicyNumberAttribute()
    {
        return $this->insurance_policy_number;
    }

    public function getEmployerNameAttribute()
    {
        return $this->name_of_employer;
    }

    public function getCompanyNameAttribute()
    {
        return $this->insurance_name;
    }

    public function getGuarantorAttribute()
    {
        return $this->financial_guarantor_name;
    }

    public function getPersonAttribute()
    {
        return $this->insurance_person;
    }

    public function getPlanNameAttribute()
    {
        return $this->insurance_plan_name;
    }

    public function getPayerIdAttribute()
    {
        return payer_list::where('name', $this->company_name)->first()->payer_id;
    }

    public function claims()
    {
        return $this->hasMany(claim::class);
    }

}
