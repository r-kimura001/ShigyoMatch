<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Follow;
use Faker\Generator as Faker;

$factory->define(Follow::class, function (Faker $faker) {
  return [
    'follower_id' => 1,
  ];
});
