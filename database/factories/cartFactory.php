<?php

use Faker\Generator as Faker;

$factory->define(App\cart::class, function (Faker $faker) {
    return [
        'doctor_id'            => 1,
        'cpt'                  => 49505,
        'date_of_appointment'  => date('Y-m-d'),
        'time_of_appointment'  => date('H:i'),
        'purchase_cost'        => $faker->numberBetween(50, 500),
        'saved_cost'           => $faker->numberBetween(50, 500),
        'anesthesia_fee'       => 15,
        'facility_expenses'    => 20,
        'bundle_treatment'     => 30,
        'date_of_booking'      => now(),
        'created_at'           => now(),
        'updated_at'           => now()
    ];
});
