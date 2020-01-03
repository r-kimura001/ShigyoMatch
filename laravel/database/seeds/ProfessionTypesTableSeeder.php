<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ProfessionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $now = Carbon::now();
      DB::table('profession_types')->truncate();
      DB::table('profession_types')->insert([
        ['body' => '弁護士','created_at' => $now,'updated_at' => $now],
        ['body' => '司法書士','created_at' => $now,'updated_at' => $now],
        ['body' => '行政書士','created_at' => $now,'updated_at' => $now],
        ['body' => '税理士','created_at' => $now,'updated_at' => $now],
      ]);

    }
}
