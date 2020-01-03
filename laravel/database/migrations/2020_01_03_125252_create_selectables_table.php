<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectablesTable extends Migration
{
    /**
     * Run the migrations.
     * 士業が選択できる分野を制御する中間テーブル（司法書士が税理士業のスキルを選択できないようにする）
     * @return void
     */
    public function up()
    {
      Schema::create('selectables', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('profession_type_id');
        $table->bigInteger('skill_type_id');
        $table->timestamps();
        $table->softDeletes();

        // 外部キー制約を設定するとseedingの際面倒なのであえて設定しない
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('selectables');
    }
}
