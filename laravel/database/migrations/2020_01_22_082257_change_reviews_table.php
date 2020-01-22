<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('reviews', function(Blueprint $table){
        $table->dropColumn('work_id');
        $table->bigInteger('apply_id')->after('id');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('reviews', function(Blueprint $table){
        $table->dropColumn('apply_id');
        $table->bigInteger('work_id')->after('id');
      });
    }
}
