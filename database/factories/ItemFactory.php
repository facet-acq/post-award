<?php

use App\Item;
use Faker\Generator as Faker;
use App\Agreement;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'agreement_uuid' => factory(Agreement::class)->create()->uuid,
        'item_identifier' => $faker->regexify('[0-9]{4}[A-Z]{0,2}'),
        'quantity' => $faker->randomNumber(),
        'unit_cost' => $faker->randomFloat(2),
    ];
});
