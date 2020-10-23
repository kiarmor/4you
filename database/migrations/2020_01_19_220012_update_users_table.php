<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('middle_name')->nullable();
            $table->text('country_code')->nullable();
            $table->text('phone');
            $table->text('ref_card')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('middle_name');
            $table->dropColumn('country_code');
            $table->dropColumn('phone');
            $table->dropColumn('ref_card');
        });
    }
}
