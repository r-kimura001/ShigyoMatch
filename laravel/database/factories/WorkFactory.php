<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Work;
use Faker\Generator as Faker;
$now = Carbon\Carbon::now();
$faker = \Faker\Factory::create('ja_JP');

$factory->define(Work::class, function () use ($faker, $now) {
  return [
    'customer_id' => 1,
    'profession_type_id' => 1,
    'title' => $faker->sentence(3),
    'body' => $faker->text,
    'fee' => floor($faker->numberBetween(1000, 200000) / 100) * 100,
    'file_name' => null,
    'created_at' => $now,
    'updated_at' => $now,
  ];
});
