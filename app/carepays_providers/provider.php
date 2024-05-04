<?php

namespace App\carepays_providers;

use App\remark_code;
use App\carepays_providers\payer;
use App\carepays_providers\practise;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\Builder;
use App\carepays_providers\provider_claim;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class provider extends Authenticatable implements JWTSubject
{
    use LaratrustUserTrait, SoftDeletes, Notifiable;

    protected $hidden = [
        'email_verified_at',
        'email_token',
        'password',
        'updated_at'
    ];

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'practise_id',
        'name',
        'email',
        'password',
        'email_token',
        'npi',
        'is_doctor',
        'email_verified_at',
        'created_by',
        'image',
        'active',
        'taxonomy_code'
    ];

    protected $appends = [
        'providerImage',
        'verified'
    ];

    const COLLECTOR_ID = 3;
    const MANAGER_ID   = 2;
    const ADMIN_ID     = 1;

    public function permissionNames()
    {
        return $this->allPermissions()->pluck('name')
            ->map(function ($permission) {
                return explode('-', $permission);
            })->toArray();
    }

    public function getVerifiedAttribute()
    {
        return $this->email_verified_at !== null;
    }

    public function getProviderImageAttribute()
    {
        if ($this->image) {
            return config('app.url') . '/storage/' . $this->image;
        } else {
            return asset('storage/' . $this->defaultImage());
        }
    }

    public function defaultImage()
    {
        return "images/providers/default.png";
    }

    public function scopeByPractise(Builder $builder, $provider)
    {
        return $builder->where('providers.practise_id', $provider->practise_id);
    }

    public function scopeNotSelf(Builder $builder, $provider)
    {
        return $builder->where('providers.id', '<>', $provider->id);
    }

    public function scopeNotManagers(Builder $builder, $provider)
    {
        return $builder->join('role_user', 'role_id', '=', $provider->id);
    }

    public function scopeCollectors(Builder $builder)
    {
        return $builder->join('role_user', 'user_id', '=', 'providers.id')
            ->where('role_id', '=', self::COLLECTOR_ID);
    }

    public function attachRemarkCode($remark_code)
    {
        $this->remark_codes()->attach($remark_code);
    }

    public function attachPayers($payers)
    {
        $payers = $this->formatPayersData($payers);
        return payer::insert($payers);
    }

    public function formatPayersData($payers)
    {
        $data = [];
        foreach ($payers as $payer) {
            $data[] = [
                'payer_id'    => $payer,
                'provider_id' => $this->id
            ];
        }
        return $data;
    }

    public function practise()
    {
        return $this->belongsTo(practise::class);
    }

    public function remark_codes()
    {
        return $this->morphedByMany(remark_code::class, 'responsable', 'provider_responsibility');
    }


    public function claims()
    {
        return $this->hasMany(provider_claim::class);
    }

    public function payers()
    {
        return payer::where('provider_id', $this->id)->get();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function sup()
    {
        return $this->getJWTIdentifier();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
