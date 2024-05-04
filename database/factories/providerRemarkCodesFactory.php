<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\carepays_providers\claim_remark_code;
use App\carepays_providers\remark_code;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

$factory->define(claim_remark_code::class, function (Faker $faker) {
    $remark_codes = remark_code::pluck('remark_code')->toArray();
    $types = ['low_fruit', 'avoidable', 'compliance'];
    return [
        'claim_id' => rand(1, 100),
        'code'     => $remark_codes[array_rand($remark_codes)],
        'type'     => $types[rand(0, 2)]
    ];
});
