<?php

namespace App\Listeners\order;

use App\order;
use App\Events\order\orderpaymentFailed;

class markOrderStatusFailed
{
    public function handle(orderpaymentFailed $event)
    {
        $event->order->update([
            'order_status' => (new order)->status('payment_failed')
        ]);
    }
}
