<?php

use Faker\Generator as Faker;

$factory->define(App\Agreement::class, function (Faker $faker) {
    return [
        'order_identifier' => $faker->word()
    ];
});
