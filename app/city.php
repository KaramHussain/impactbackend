<?php

namespace App;

use App\user_address;
use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    public function user()
    {
        return $this->belongsTo(user_address::class);
    }
}
