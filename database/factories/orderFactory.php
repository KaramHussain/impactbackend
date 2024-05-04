<?php

use App\payments\paymentMethod;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\order::class, function (Faker $faker) {
    $status = ['payment_failed', 'processing', 'complete'];
    return [
        'order_id'          => Str::random(20),
        'order_status'      => $status[rand(0, 2)],
        'created_at'        => now(),
        'total'             => $faker->randomNumber(5)
    ];
});
