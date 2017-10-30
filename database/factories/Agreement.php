<?php

use Faker\Generator as Faker;

$factory->define(App\Agreement::class, function (Faker $faker) {
    return [
        'order' => $faker->word(),
        'release' => $faker->word(),
        'effective_date' => \Carbon\Carbon::now(),
        'total_value' => $faker->randomFloat(2)
    ];
});
