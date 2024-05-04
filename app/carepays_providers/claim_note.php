<?php

namespace App\carepays_providers;

use Illuminate\Database\Eloquent\Model;
use App\carepays_providers\provider_claim;

class claim_note extends Model
{
    protected $guarded = ['id'];

    public function claim() 
    {
        return $this->belongsTo(provider_claim::class, 'claim_id');
    }
}