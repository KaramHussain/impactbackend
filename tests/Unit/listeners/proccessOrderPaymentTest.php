<?php

namespace Tests\Unit\listeners;

use App\Events\order\mailUserOrderCreated;
use App\Events\order\orderPaymentFailed;
use App\Events\order\orderCreated;
use App\Exceptions\paymentFailedException;
use App\Listeners\order\processPayment;
use App\order;
use App\paymentGateways\gateways\stripeGateway;
use App\paymentGateways\gateways\stripeGatewayCustomer;
use App\payments\paymentMethod;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class proccessOrderPaymentTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_charges_the_chosen_payment_correct_amount()
    {
       \Event::fake();

       list($user, $payment_method, $order, $event) = $this->createEvent();

       list($gateway, $customer) = $this->mockFlow();

        $customer->shouldReceive('charge')->with(
            $order->paymentMethod, $order->total()
        );

        $listener = new processPayment($gateway);
        $listener->handle($event);

    }

    public function test_it_throws_Exception_when_payment_failed()
    {
        \Event::fake();

        list($user, $payment_method, $order, $event) = $this->createEvent();

        list($gateway, $customer) = $this->mockFlow();

        $customer->shouldReceive('charge')->with(
            $order->paymentMethod, $order->total()
        )
        ->andThrow(paymentFailedException::class);

        $listener = new processPayment($gateway);
        $listener->handle($event);

        \Event::assertDispatched(orderPaymentFailed::class, function($event) use ($order) {
            return $event->order->id == $order->id;
        });
    }

    public function test_it_sends_email_to_user_when_order_passed()
    {
        \Event::fake();

        list($user, $payment_method, $order, $event) = $this->createEvent();

        list($gateway, $customer) = $this->mockFlow();

        $customer->shouldReceive('charge')->with(
            $order->paymentMethod, $order->total()
        );

        $listener = new processPayment($gateway);
        $listener->handle($event);

        \Event::assertDispatched(mailUserOrderCreated::class, function($event) use ($order) {
            return $event->order->user->first_name == $order->user->first_name;
        });

    }

    protected function createEvent()
    {
        $user = factory(User::class)->create();
        $payment_method = factory(paymentMethod::class)->create([
            'user_id' => $user->id
        ]);

        $event = new orderCreated(
            $order = factory(order::class)->create([
                'user_id' => $user->id,
                'payment_method_id' => $payment_method->id
            ])
        );
        return [$user, $payment_method, $order, $event];
    }

    protected function mockFlow()
    {
        $gateway = Mockery::mock(stripeGateway::class);

        $gateway->shouldReceive('withUser')
                ->andReturn($gateway)
                ->shouldReceive('getCustomer')
                ->andReturn(
                    $customer = Mockery::mock(stripeGatewayCustomer::class)
                );
        return [$gateway, $customer];
    }
}
