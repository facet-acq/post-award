<?php

use App\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'item_identifier' => $faker->regexify('[0-9]{4}[A-Z]{0,2}'),
        'quantity' => $faker->randomNumber(),
        'unit_cost' => $faker->randomFloat(2),
    ];
});
