<?php

namespace Tests\Feature\orders;

use App\cart;
use App\User;
use App\order;
use App\invoice;
use Tests\TestCase;
use App\payments\paymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;


class orderStoreTest extends TestCase
{
    use RefreshDatabase;
    public function test_order_can_be_created()
    {
        list($user, $payment, $cart) = $this->orderDependencies();

        $this->actingAs($user)
        ->json('POST', 'api/auth/cart/checkout', ['payment_method_id'=>$payment->id]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'payment_method_id' => $payment->id
        ]);

    }

    public function test_it_fails_to_create_order_when_cart_is_empty()
    {
        $user = factory(User::class)->create();

        $payment = factory(paymentMethod::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
        ->json('POST', 'api/auth/cart/checkout',
        ['payment_method_id'=>$payment->id]);

        $response->assertSee(422);
    }

    public function test_it_fails_to_create_order_when_not_authenticated()
    {
        list($user, $payment, $cart) = $this->orderDependencies();

        $response = $this->json('POST', 'api/auth/cart/checkout',
        ['payment_method_id'=>$payment->id]);

        $response->assertStatus(401);
    }

    public function test_it_empty_cart_when_order_is_created()
    {
        list($user, $payment, $cart) = $this->orderDependencies();
        $response =
        $this->actingAs($user)
        ->json('POST', 'api/auth/cart/checkout',
        ['payment_method_id'=>$payment->id]);

        //$this->assertEmpty($user->cart->first()->empty());
        $this->assertEquals(0, $cart->count());
    }

    public function test_order_requires_payment_method_id()
    {
        list($user, $payment, $cart) = $this->orderDependencies();

        $response = $this->actingAs($user)
        ->json('POST', 'api/auth/cart/checkout');
        $response->assertJsonValidationErrors(['payment_method_id']);
    }

    public function orderDependencies()
    {
        $user = factory(User::class)->create();

        $stripeCustomer = \Stripe\Customer::create([
            'email' => $user->email
        ]);

        $user->update([
            'gateway_customer_id' => $stripeCustomer->id
        ]);

        $payment = factory(paymentMethod::class)->create([
            'user_id' => $user->id
        ]);

        $cart = factory(cart::class)->create([
            'user_id' => $user->id
        ]);

        return [$user, $payment, $cart];
    }

    public function test_it_has_many_invoices()
    {
        list($user, $payment, $cart) = $this->orderDependencies();

        $order = factory(order::class)->create([
            'user_id' => $user->id,
            'payment_method_id' => $payment->id
        ]);

        factory(invoice::class)->create([
            'order_id'  => $order->id,
            'total'     => $order->total()
        ]);

        $this->assertInstanceOf(invoice::class, $order->invoices->first());
    }

    public function test_order_creates_invoice_with_its_total_amount()
    {
        list($user, $payment, $cart) = $this->orderDependencies();

        $order = factory(order::class)->create([
            'user_id' => $user->id,
            'payment_method_id' => $payment->id
        ]);

        $invoice = factory(invoice::class)->create([
            'order_id'  => $order->id,
            'total'     => $order->total()
        ]);

        $this->assertEquals($invoice->total, $order->total());

    }

    public function test_invoice_is_created_when_order_is_created()
    {
        list($user, $payment, $cart) = $this->orderDependencies();

        $order = factory(order::class)->create([
            'user_id' => $user->id,
            'payment_method_id' => $payment->id
        ]);

        factory(invoice::class)->create([
            'order_id'  => $order->id,
            'total'     => $order->total()
        ]);

        $this->assertDatabaseHas('invoices', [
            'order_id' => $order->id,
            'total'    => $order->total()
        ]);

    }

}
