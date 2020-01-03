<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('note_template_id');
          $table->bigInteger('receiver_id');
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
        Schema::dropIfExists('notes');
    }
}
