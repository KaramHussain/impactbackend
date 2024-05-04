<?php

namespace App\notifications;

use Illuminate\Database\Eloquent\Model;

class subscriber extends Model
{
    protected $fillable = [
        'email'
    ];
}
