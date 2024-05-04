<?php

use Faker\Generator as Faker;

$factory->define(App\invoice::class, function (Faker $faker) {
    return [
        'created_at' => now()
    ];
});
