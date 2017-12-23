<?php

use Carbon\Carbon;
use App\SloaAccountingLine;
use Faker\Generator as Faker;

$factory->define(SloaAccountingLine::class, function (Faker $faker) {
    return [
        'sub_class' => null,
        'department_transfer' => null,
        'department_regular' => $faker->randomElement(['021', '017', '057', '097']),
        'bpoa' => Carbon::instance($faker->dateTimeInInterval('now', '+ 1 year')),
        'epoa' => Carbon::instance($faker->dateTimeBetween('+ 2 years', '+ 3 years')),
        'availability_type' => null,
        'main_account' => $faker->regexify('[A-Z0-9]{4}'),
        'sub_account' => $faker->regexify('[0-9]{3}'),
        'business_event_type_code' => $faker->regexify('[A-Z0-9]{1,8}'),
        'object_class' => $faker->regexify('[0-9]{3,6}'),
        'reimbursable_flag' => $faker->randomElement(['D', 'R']),
        'budget_line_item' => $faker->regexify('[A-Z0-9]{3,16}'),
        'security_cooperation' => $faker->countryISOAlpha3,
        'security_cooperation_implementing_agency_code' => $faker->randomElement(['B', 'D', 'P']),
        'security_cooperation_case_designator' => $faker->regexify('[A-Z0-9]{3,4}'),
        'security_cooperation_case_line_item_identifier' => $faker->regexify('[0-9]{3}'),
        'sub_allocation' => $faker->regexify('[0-9]{4}'),
        'agency_disbursing_identifier_code' => $faker->regexify('[0-9]{4,8}'),
        'agency_accounting_identifier' => $faker->regexify('[0-9]{6}'),
        'funding_center_identifier' => $faker->regexify('[A-Z0-9]{16}'),
        'cost_center_identifier' => $faker->regexify('[A-Z0-9]{16}'),
        'project_identifier' => $faker->regexify('[A-Z0-9]{25}'),
        'activity_identifier' => $faker->regexify('[A-Z0-9]{16}'),
        'cost_element_code' => $faker->regexify('[A-Z0-9]{15}'),
        'work_order_number' => $faker->regexify('[A-Z0-9]{16}'),
        'functional_area' => $faker->regexify('[A-Z0-9]{16}'),
    ];
});
