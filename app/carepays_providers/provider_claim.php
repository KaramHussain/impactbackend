<?php

namespace App\carepays_providers;

use Illuminate\Http\Request;
use App\carepays_providers\provider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\carepays_providers\claim_remark_code;
use App\filters\providerClaims\claimFilters;

class provider_claim extends Model
{

    protected $guarded = ['id'];
    const DEFAULT_STATUS = "to_be_reviewed";
    const SUBMITTED = "submitted";
    const ASSIGNED = "assigned";
    const RESOLVED = "resolved";


    public function provider() 
    {
        return $this->belongsTo(provider::class);
    }
    
    public function notes() 
    {   
        return $this->hasMany(claim_note::class, 'claim_id');
    }

    public function scopeFilter(Builder $builder, Request $request, array $filters = []) 
    {
        return (new claimFilters($request))->add($filters)->filter($builder);
    }

    public function remark_codes() 
    {
        return $this->hasMany(claim_remark_code::class, 'claim_id');
    }

    public function scopeFindByClaimId(Builder $builder, $claim_id)
    {
        return $builder->where('claim_id', $claim_id);
    }

    public static function boot() 
    {
        parent::boot();
        static::creating(function($model) {
            $model->status = self::DEFAULT_STATUS;
        });
    }

}
