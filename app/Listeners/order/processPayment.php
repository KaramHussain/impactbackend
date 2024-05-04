<?php

namespace App\Listeners\order;

use App\Events\order\orderCreated;
use App\paymentGateways\gateway;
use App\Events\order\orderPaymentFailed;
use App\Events\order\mailUserOrderCreated;
use App\Exceptions\paymentFailedException;


class processPayment
{
    public $gateway;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Handle the event.
     *
     * @param  orderCreated  $event
     * @return void
     */
    public function handle(orderCreated $event)
    {
        try {
            $order = $event->order;
            $this->gateway->withUser($order->user)
                 ->getCustomer()
                 ->charge(
                    $order->paymentMethod, ($order->total() * 100)
                 );

            //event
            event(new mailUserOrderCreated($order));

        }   catch (paymentFailedException $e) {

            event(new orderPaymentFailed($order));

        }

    }
}
