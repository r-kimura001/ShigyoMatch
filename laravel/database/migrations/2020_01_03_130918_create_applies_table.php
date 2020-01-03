<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('applies', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('work_id');
        $table->bigInteger('applier_id');
        $table->tinyInteger('match_flag')->default(0);
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
      Schema::dropIfExists('applies');
    }
}
