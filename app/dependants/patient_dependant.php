<?php

namespace App\dependants;

use App\User;
use App\insurance\patient_insurance;
use Illuminate\Database\Eloquent\Model;

class patient_dependant extends Model
{
    protected $fillable = [
        'dependant_name',
        'dependant_relation',
        'user_id'
    ];

    public function insurance()
    {
        return $this->belongsTo(patient_insurance::class, 'insurance_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
