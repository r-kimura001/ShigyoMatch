<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\WorkSkill;
use Faker\Generator as Faker;
use Carbon\Carbon;

$now = Carbon::now();

$factory->define(WorkSkill::class, function (Faker $faker) use ($now){
    return [
      'work_id' => 1,
      'skill_type_id' => 1,
      'created_at' => $now,
      'updated_at' => $now,
    ];
});
