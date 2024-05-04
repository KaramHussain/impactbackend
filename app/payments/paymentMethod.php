<?php

namespace App\payments;

use App\{order, User};
use App\traits\canBeDefault;
use Illuminate\Database\Eloquent\Model;

class paymentMethod extends Model
{
    use canBeDefault;

    protected $fillable = [
        'user_id',
        'provider_id',
        'card_type',
        'last_four',
        'default'
    ];

    protected $hidden = ['provider_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->hasOne(order::class);
    }

}
