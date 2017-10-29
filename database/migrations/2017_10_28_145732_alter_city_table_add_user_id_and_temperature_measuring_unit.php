<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCityTableAddUserIdAndTemperatureMeasuringUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('cities', function($table) {
        $table->integer('user_id')->unsigned();
        $table->string('measuring_unit');

        $table->foreign('user_id')->references('id')->on('users');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('cities', function($table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('measuring_unit');
      });
    }
}
