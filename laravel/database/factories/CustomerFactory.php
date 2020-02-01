<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use Faker\Generator as Faker;
$now = Carbon\Carbon::now();
$faker = \Faker\Factory::create('ja_JP');
$factory->define(Customer::class, function () use ($faker, $now) {
  return [
    'name' => $faker->userName . '事務所',
    'zip_code' => $faker->postcode,
    'pref_code' => $faker->numberBetween(1, 47),
    'city' => $faker->city,
    'address' => $faker->streetAddress,
    'building' => null,
    'url' => $faker->url,
    'file_name' => null,
    'greeting' => $faker->text(50),
    'created_at' => $now,
    'updated_at' => $now,
  ];
});
