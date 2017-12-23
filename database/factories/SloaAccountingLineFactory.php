<?php

use App\SloaAccountingLine;
use Faker\Generator as Faker;

$factory->define(SloaAccountingLine::class, function (Faker $faker) {
    return [
        'sub_class' => null,
        'department_transfer' => null
    ];
});
