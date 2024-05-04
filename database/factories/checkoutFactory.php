<?php

use Faker\Generator as Faker;

$factory->define(App\checkout::class, function (Faker $faker) {
    return [
        'doctor_id'           => 1,
        'cpt'                 => 1,
        'date_of_appointment' => date('Y-m-d'),
        'time_of_appointment' => date('H:i'),
        'date_of_booking'     => now(),
        'purchase_cost'       => $faker->numberBetween(50, 500),
        'saved_cost'          => $faker->numberBetween(50, 500),
        'anesthesia_fee'      => 15,
        'facility_expenses'   => 30,
        'bundle_treatment'    => 25
    ];
});
