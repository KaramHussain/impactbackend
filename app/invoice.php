<?php

namespace App;

use App\order;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    public $timestamps = false;
    protected $hidden = ['order_id'];
    protected $fillable = ['created_at', 'total'];

    public function order()
    {
        return $this->belongsTo(order::class);
    }

}
