<?php

namespace App\claims;

use App\claims\{claim, claim_dx_pointer};
use Illuminate\Database\Eloquent\Model;

class claim_treatment extends Model
{
    protected $fillable = [

        'claim_id',
        'cpt_code',
        'cpt_status',
        'cpt_description',
        'dx1',
        'dx2',
        'dx3',
        'dx4',
        'pos',
        'tos',
        'cpt_units',
        'cpt_charged_amount',
        'cpt_allowed_amount',
        'cpt_expected_amount',

    ];

    public function claim()
    {
        return $this->belongsTo(claim::class);
    }

    public function pointers()
    {
        return $this->hasMany(claim_dx_pointer::class, 'treatment_id');
    }

}
