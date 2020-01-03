<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('scouts', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('work_id');
        $table->bigInteger('scouted_id'); //スカウトを受けた人
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
      Schema::dropIfExists('scouts');
    }
}
