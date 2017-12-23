<?php

use App\Fund;
use Faker\Generator as Faker;

$factory->define(Fund::class, function (Faker $faker) {
    return [
        'amount' => $faker->randomFloat()
    ];
});
