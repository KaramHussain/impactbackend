<?php

namespace App\Events\order;

use App\order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class orderPaymentFailed
{
    use Dispatchable, SerializesModels;

    public $order;
    public function __construct(order $order)
    {
        $this->order = $order;
    }


}
