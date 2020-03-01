<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use Faker\Generator as Faker;
$now = Carbon\Carbon::now();
$faker = \Faker\Factory::create('ja_JP');
$greetingList = [
  "スピード感と正確性を兼ね備え、高評価を頂いております",
  "昨年独立開業。\n年間600件あまりの受託を経験し、ますますのお引き合いを頂いております。",
  "昨年開業10年を迎え、事業拡大中。\n人員増員につき、多数募集しております。",
];
$factory->define(Customer::class, function () use ($faker, $now, $greetingList) {

  $randomKey = rand(0, count($greetingList) - 1);

  return [
    'name' => $faker->userName . '事務所',
    'zip_code' => $faker->postcode,
    'pref_code' => $faker->numberBetween(1, 47),
    'city' => $faker->city,
    'address' => $faker->streetAddress,
    'building' => null,
    'url' => $faker->url,
    'file_name' => null,
    'greeting' => $greetingList[$randomKey],
    'created_at' => $now,
    'updated_at' => $now,
  ];

});
