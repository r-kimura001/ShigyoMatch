<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('works', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('customer_id');
        $table->bigInteger('profession_type_id');
        $table->string('title');
        $table->text('body');
        $table->integer('fee')->nullable();
        $table->string('file_name')->unique()->nullable();
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
      Schema::dropIfExists('works');
    }
}
