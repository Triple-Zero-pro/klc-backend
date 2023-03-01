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
        Schema::table('service_attributes', function (Blueprint $table) {
            //
             $table->boolean('contract_image')->default(0);
             $table->boolean('arrive_image_airport')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_attributes', function (Blueprint $table) {
            //
             $table->dropColumn('contract_image');
             $table->dropColumn('arrive_image_airport');
        });
    }
};
