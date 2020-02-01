<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CustomerProfessionType;
use Faker\Generator as Faker;
$now = Carbon\Carbon::now();
$faker = \Faker\Factory::create('ja_JP');
$factory->define(CustomerProfessionType::class, function () use ($faker, $now) {
  return [
    'customer_id' => 1,
    'profession_type_id' => $faker->numberBetween(1, 4),
    'register_number' => $faker->randomNumber(8),
    'created_at' => $now,
    'updated_at' => $now,
  ];
});
