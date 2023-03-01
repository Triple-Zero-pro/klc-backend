<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_service_form', function (Blueprint $table) {
            //
            $table->string('contract_image')->nullable();
            $table->string('arrive_image_airport')->nullable();

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
            $table->dropColumn('contract_image');
            $table->dropColumn('arrive_image_airport');

        });
    }
};
