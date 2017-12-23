<?php

use App\Fund;
use Faker\Generator as Faker;
use App\SloaAccountingLine;

$factory->define(Fund::class, function (Faker $faker) {
    $sloaAccountingLine = factory(SloaAccountingLine::class)->create();

    return [
        'accountable_type' => '\App\SloaAccountingLine',
        'accountable_id' => $sloaAccountingLine->uuid,
        'amount' => $faker->randomFloat()
    ];
});
