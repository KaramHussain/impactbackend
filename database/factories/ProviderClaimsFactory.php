<?php

use Faker\Generator as Faker;
use \App\carepays_providers\practise;

$factory->define('App\carepays_providers\provider_claim', function (Faker $faker) {
    $practise_ids = practise::pluck('id')->toArray();
    $remark_types = ['low_fruit', 'compliance', 'avoidable'];
    $payers = ['1216000928', '1231294723', '1463867722'];
    return [
        'claim_id'    => $faker->uuid,
        'status'      => 'to_be_reviewed',
        'practise_id' => $practise_ids[array_rand($practise_ids, 1)],
        'payer_id'    => $payers[array_rand($payers, 1)],
        'date_of_service' => date('Y-m-d', strtotime( '+'.mt_rand(0, 30).' days')),
        'patient_name' => $faker->name,
        'doctor_name'  => $faker->name,
        'payer_name'  => $faker->name,
        'total_claim_charges' => $faker->randomNumber(),
        'patient_responsibility' => $faker->randomNumber(),
        'total_paid_amount' => $faker->randomNumber(),
        'claim_status'  => ['rejected', 'accepted', 'denied'][rand(0, 2)]
    ];
});
