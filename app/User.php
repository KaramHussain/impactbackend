<?php

namespace App;

use App\{user_address, cart, order, checkout, language};
use App\claims\claim;
use App\payments\paymentMethod;
use App\insurance\patient_insurance;
use App\dependants\patient_dependant;
use Illuminate\Database\Eloquent\Builder;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'phone',
        'alt_phone',
        'email',
        'alt_email',
        'password',
        'credentials',
        'gender',
        'dob',
        'security_question1',
        'security_question2',
        'security_answer1',
        'security_answer2',
        'language',
        'active',
        'activation_token',
        'gateway_customer_id',
        'user_image'
    ];

    protected $attributes = [
        'active' => 0,
        'user_image' => 'images/users/default.png'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'gateway_customer_id',
        'email_verified_at',
        'activation_token',
        'active'
    ];

    public $timestamps = true;

    public function getImageAttribute()
    {
        return asset('storage/'.$this->user_image);
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

    public function scopeByActivationColumns(Builder $builder, $token, $email)
    {
        return $builder->where('activation_token', $token)->where('email', $email);
    }

    public function address()
    {
        return $this->hasOne(user_address::class);
    }

    public function dependants()
    {
        return $this->hasMany(patient_dependant::class);
    }

    public function insurances()
    {
        return $this->hasMany(patient_insurance::class);
    }

    public function cart()
    {
        return $this->hasMany(cart::class);
    }

    public function order()
    {
        return $this->hasMany(order::class);
    }

    public function checkouts()
    {
        return $this->hasMany(checkout::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(paymentMethod::class);
    }

    public function claims()
    {
        return $this->hasMany(claim::class);
    }

    public function language()
    {
        return $this->hasOne(language::class);
    }

}

