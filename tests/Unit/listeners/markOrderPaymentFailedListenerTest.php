<?php

namespace Tests\Unit\listeners;

use App\Events\order\orderPaymentFailed;
use App\Listeners\order\markOrderStatusFailed;
use App\order;
use App\payments\paymentMethod;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class markOrderPaymentFailedListenerTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_marks_order_as_payment_failed()
    {
        $event = new orderPaymentFailed(
            $order = factory(order::class)->create([
                'user_id' => $user = factory(User::class)->create(),
                'payment_method_id' => factory(paymentMethod::class)->create([
                    'user_id' => $user->id
                ])
            ])
        );

        $listener = new markOrderStatusFailed;
        $listener->handle($event);

        $this->assertEquals($order->order_status, 'payment_failed');

    }

}
