<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Selectable;
use Faker\Generator as Faker;
use Carbon\Carbon;

$now = Carbon::now();

$factory->define(Selectable::class, function (Faker $faker) use ($now){
    return [
      'profession_type_id' => 1,
      'skill_type_id' => 1,
      'created_at' => $now,
      'updated_at' => $now,
    ];
});
