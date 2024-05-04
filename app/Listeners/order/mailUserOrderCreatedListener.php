<?php

namespace App\Listeners\order;

use App\Events\order\mailUserOrderCreated;
use App\Mail\order\orderCreatedSuccessfully;
use Illuminate\Support\Facades\Mail;

class mailUserOrderCreatedListener
{

    public function handle(mailUserOrderCreated $event)
    {
        $order = $event->order;
        Mail::to($order->user->email)->send(new orderCreatedSuccessfully($order));
    }
}
