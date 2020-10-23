<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('period_1');
            $table->integer('period_2');
            $table->integer('period_3');
            $table->integer('period_4');
            $table->integer('period_5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tariff');
    }
}
