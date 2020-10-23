<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('gifts', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->bigInteger('user_id')->unsigned()->nullable();
        //     $table->foreign('user_id')->references('id')->on('users');
        //     $table->text('secret');
        //     $table->timestamps();
        // });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('gifts')->default(0);
            $table->boolean('gift_activated')->default(false);
        });

        Schema::table('purchased', function (Blueprint $table) {
            $table->boolean('active')->default(true);
        });

        Schema::table('tariff', function (Blueprint $table) {
            $table->boolean('is_gift')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('gifts');
        Schema::table('users',  function (Blueprint $table) {
            $table->dropColumn('gifts');
            $table->dropColumn('gift_activated');
        });

        Schema::table('purchased', function (Blueprint $table) {
            $table->dropColumn('active');
        });

        Schema::table('tariff', function (Blueprint $table) {
            $table->dropColumn('is_gift');
        });
    }
}
