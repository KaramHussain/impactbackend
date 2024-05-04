<?php

namespace Tests\Unit\payments;

use App\payments\paymentMethod;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class paymentMethodsTest extends TestCase
{
    use RefreshDatabase;
    public function test_it_set_default_to_false_when_creating_new_payment()
    {
        $user = factory(User::class)->create();

        $oldPaymentMethod = factory(paymentMethod::class)->create([
            'user_id' => $user->id,
            'default' => true
        ]);

        factory(paymentMethod::class)->create([
            'user_id' => $user->id,
            'default' => true
        ]);

        $this->assertEquals(0, $oldPaymentMethod->fresh()->default);

    }

    public function test_it_belongs_to_user()
    {
        $user = factory(User::class)->create();

        $paymentMethod = factory(paymentMethod::class)->create([
            'user_id' => $user->id,
            'default' => true
        ]);

        $this->assertInstanceOf(User::class, $paymentMethod->user);
    }
}
