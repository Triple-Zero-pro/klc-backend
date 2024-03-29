<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_service_form', function (Blueprint $table) {
            //
            $table->string('going_date')->nullable();
            $table->string('going_time')->nullable();
            $table->string('return_date')->nullable();
            $table->string('return_time')->nullable();
            $table->string('birth_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_service_form', function (Blueprint $table) {
            //
            $table->dropColumn('going_date');
            $table->dropColumn('going_time');
            $table->dropColumn('return_date');
            $table->dropColumn('return_time');
            $table->dropColumn('birth_date');

        });
    }
};
