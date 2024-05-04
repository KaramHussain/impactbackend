<?php

namespace App\carepays_providers;

use App\carepays_providers\provider;
use Illuminate\Database\Eloquent\Model;

class payer extends Model
{
    protected $table = "provider_attached_payers";

    protected $fillable = [
        'provider_id',
        'payer_id'
    ];

    public function providers()
    {
        $provider_ids = static::where('payer_id', $this->payer_id)->pluck('provider_id');
        return provider::whereIn('id', $provider_ids)->get();
    }

}
