<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('country_name');
            $table->text('country_code');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('country_code');
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_country_id_foreign');
            $table->text('country_code')->nullable();
        });
    }
}
