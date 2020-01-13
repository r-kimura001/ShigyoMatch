<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // SQLite対策のため一旦nullable
      Schema::table('scouts', function(Blueprint $table){
        $table->string('title')->nullable()->after('scouted_id');
        $table->text('body')->nullable()->after('title');
      });
      Schema::table('scouts', function(Blueprint $table){
        $table->string('title')->nullable(false)->change();
      });
      Schema::table('scouts', function(Blueprint $table){
        $table->text('body')->nullable(false)->change();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('scouts', function(Blueprint $table){
        $table->dropColumn('body');
      });
      Schema::table('scouts', function(Blueprint $table){
        $table->dropColumn('title');
      });

    }
}
