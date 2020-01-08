<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('customers', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name');
      $table->string('zip_code')->nullable();
      $table->integer('pref_code')->nullable();
      $table->string('city')->nullable();
      $table->string('address')->nullable();
      $table->string('building')->nullable();
      $table->string('url')->nullable();
      $table->string('file_name', 80)->unique()->nullable();
      $table->text('greeting')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('customers');
  }
}
