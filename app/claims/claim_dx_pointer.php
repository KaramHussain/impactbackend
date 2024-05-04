<?php

namespace App\claims;

use App\claims\{claim, claim_treatment};
use Illuminate\Database\Eloquent\Model;

class claim_dx_pointer extends Model
{
    protected $fillable = [
        'claim_id',
        'treatment_id',
        'cpt',
        'dx1',
        'dx2',
        'dx3',
        'dx4',
        'dx5',
        'dx6',
        'dx7',
        'dx8',
        'dx9',
        'dx10',
        'dx11',
        'dx12'
    ];

    public function claim()
    {
        return $this->belongsTo(claim::class);
    }

    public function treatment()
    {
        return $this->belongsTo(claim_treatment::class, 'treatment_id');
    }

}
