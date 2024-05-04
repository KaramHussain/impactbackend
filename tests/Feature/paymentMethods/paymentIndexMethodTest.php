<?php

namespace Tests\Feature\paymentMethods;

use App\payments\paymentMethod;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class paymentIndexMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_fails_if_not_authenticated()
    {
        $this->json('GET', 'api/payment-methods')
        ->assertStatus(401);
    }

    public function test_it_returns_a_collection_of_payment_methods()
    {
        $user = factory(User::class)->create();

        $payment = factory(paymentMethod::class)->create([
            'user_id' => $user->id
        ]);

        $this
        ->actingAs($user)
        ->json('GET', 'api/payment-methods')
        ->assertStatus(200)
        ->assertjsonFragment([
            'id' => $payment->id
        ]);
    }
}
