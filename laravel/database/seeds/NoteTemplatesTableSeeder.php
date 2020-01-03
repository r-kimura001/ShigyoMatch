<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class NoteTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $now = Carbon::now();
      DB::table('note_templates')->truncate();
      DB::table('note_templates')->insert([
        ['type' => 'scout', 'body' => 'スカウト','created_at' => $now,'updated_at' => $now],
        ['type' => 'message', 'body' => 'メッセージ','created_at' => $now,'updated_at' => $now],
        ['type' => 'apply', 'body' => '申込','created_at' => $now,'updated_at' => $now],
        ['type' => 'match', 'body' => 'マッチング','created_at' => $now,'updated_at' => $now],
        ['type' => 'chat_message', 'body' => 'チャットメッセージ','created_at' => $now,'updated_at' => $now],
      ]);

    }
}
