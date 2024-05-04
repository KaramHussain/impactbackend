<?php

namespace App;

use App\{User, city, state};
use Illuminate\Database\Eloquent\Model;

class user_address extends Model
{
    protected $table = 'user_address';
    protected $fillable = [
        'city',
        'state',
        'address',
        'address2',
        'zipcode',
        'user_id'
    ];

    protected $appends = [
        'user_city',
        'user_state'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->hasOne(city::class);
    }

    public function state()
    {
        return $this->hasOne(state::class);
    }

    public function getUserCityAttribute()
    {
        return optional(city::find($this->city))->city;
    }

    public function getUserStateAttribute()
    {
        return optional(state::find($this->state))->state;
    }

}
