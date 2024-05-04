<?php

namespace App\admin;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;


class admin extends Authenticatable implements JWTSubject
{
    use LaratrustUserTrait, Notifiable;

    protected $guarded = ['id'];

    protected $appends = [
        'admin_image'
    ];

    public function getAdminImageAttribute()
    {
        $image = $this->image ?? $this->defaultImage();
        return asset('storage/'.$image);
    }

    public function defaultImage()
    {
        return "images/providers/default.png";
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
