<?php

namespace Tests\Feature;

use App\payments\paymentMethod;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class userTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_many_payment_methods()
    {
        $user =  factory(User::class)->create();

        factory(paymentMethod::class)->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(paymentMethod::class, $user->paymentMethods->first());
    }
}
