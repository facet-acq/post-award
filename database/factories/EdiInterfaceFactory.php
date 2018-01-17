<?php

use Faker\Generator as Faker;
use Carbon\Carbon;
use App\EdiInterface;
use App\Agreement;

$factory->define(EdiInterface::class, function (Faker $faker) {
    return [
        'agreement_uuid' => factory(Agreement::class)->create()->uuid,
        'file_size' => $faker->numberBetween(120, 10000000),
        'file_name' => $faker->word.'.edi',
        'file_type' => $faker->randomElement(['x12', 'edifact', 'xml', 'json']),
        'file_at' => Carbon::instance($faker->dateTimeInInterval('-10 days', 'now', 'UTC')),
        'interface_partner' => $faker->word,
        'interface_channel' => $faker->word,
        'interface_version' => $faker->randomElement(['003050', '003050F801_1', '004010', 'v1.0', 'v2.3', 'v2.5.1']),
        'interface_source' => $faker->randomElement(['CONWRITE', 'TEST', 'S00001']),
        'interface_destination' => $faker->randomElement(['MOCAS', 'FACET', 'NONSENSE']),
        'interface_control_number' => $faker->numberBetween(10000000, 999999999),
        'interface_at' => null,
        'queued_at' => Carbon::now(),
        'processed_at' => null
    ];
});
