<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('apply_id');
          $table->bigInteger('sender_id');
          $table->text('body');
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
      Schema::dropIfExists('messages');
    }
}
