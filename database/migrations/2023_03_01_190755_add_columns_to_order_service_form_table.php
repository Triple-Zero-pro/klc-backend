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
            $table->boolean('going_date')->default(0);
            $table->boolean('going_time')->default(0);
            $table->boolean('return_date')->default(0);
            $table->boolean('return_time')->default(0);
            $table->boolean('birth_date')->default(0);
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
