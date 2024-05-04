<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class paymentMethodsStoreTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_fails_when_not_authenticated()
    {
        $this->json('POST', 'api/payment-methods', ['token'=> 'tok_visa'])
        ->assertStatus(401);
    }

    public function test_it_fails_when_not_passed_token()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
        ->json('POST', 'api/payment-methods')
        ->assertJsonValidationErrors(['token']);
    }

    public function test_it_can_successfully_store_a_card()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
        ->json('POST', 'api/payment-methods', [
            'token' => 'tok_visa'
        ]);

        $this->assertDatabaseHas('payment_methods', [
            'card_type' => 'Visa',
            'last_four' => '4242'
        ]);
    }

    public function test_it_returns_a_card()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
        ->json('POST', 'api/payment-methods', [
            'token' => 'tok_visa'
        ])

        ->assertJsonFragment([
            'card_type' => 'Visa'
        ]);

    }

    public function test_a_new_created_card_is_default_card()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
        ->json('POST', 'api/payment-methods', [
            'token' => 'tok_visa'
        ]);

        $this->assertDatabaseHas('payment_methods', [
            'id'      => json_decode($response->getContent())->data->id,
            'default' => true
        ]);

    }

}
