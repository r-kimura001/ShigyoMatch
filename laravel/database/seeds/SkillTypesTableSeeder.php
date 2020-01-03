<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SkillTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $now = Carbon::now();
      DB::table('skill_types')->truncate();
      DB::table('skill_types')->insert([
        ['body' => '債務整理','created_at' => $now,'updated_at' => $now],
        ['body' => '債権回収','created_at' => $now,'updated_at' => $now],
        ['body' => '交通事故','created_at' => $now,'updated_at' => $now],
        ['body' => '労働問題','created_at' => $now,'updated_at' => $now],
        ['body' => '離婚・交際問題','created_at' => $now,'updated_at' => $now],
        ['body' => '刑事事件','created_at' => $now,'updated_at' => $now],
        ['body' => '不動産取引','created_at' => $now,'updated_at' => $now],
        ['body' => '遺言・相続','created_at' => $now,'updated_at' => $now],
        ['body' => '株主総会','created_at' => $now,'updated_at' => $now],
        ['body' => '契約','created_at' => $now,'updated_at' => $now],
        ['body' => '合併・M&A','created_at' => $now,'updated_at' => $now],
        ['body' => '会社設立','created_at' => $now,'updated_at' => $now],
        ['body' => '役員変更','created_at' => $now,'updated_at' => $now],
        ['body' => 'その他企業法務','created_at' => $now,'updated_at' => $now],
        ['body' => '供託','created_at' => $now,'updated_at' => $now],
        ['body' => '成年後見','created_at' => $now,'updated_at' => $now],
        ['body' => '確定申告','created_at' => $now,'updated_at' => $now],
        ['body' => '贈与','created_at' => $now,'updated_at' => $now],
        ['body' => '法人決算','created_at' => $now,'updated_at' => $now],
        ['body' => '税務調査','created_at' => $now,'updated_at' => $now],
        ['body' => '知的財産','created_at' => $now,'updated_at' => $now],
        ['body' => '営業届出','created_at' => $now,'updated_at' => $now],
        ['body' => '建設・環境','created_at' => $now,'updated_at' => $now],
        ['body' => 'その他','created_at' => $now,'updated_at' => $now],
      ]);

    }
}
