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
        Schema::create('order_service_form', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('appointment_date')->nullable();
            $table->string('appointment_time')->nullable();
            $table->string('image_front')->nullable();
            $table->string('image_back')->nullable();
            $table->string('image_ticket')->nullable();
            $table->string('image_passport')->nullable();
            $table->string('image_visa')->nullable();
            $table->string('image_office')->nullable();
            $table->string('gender')->nullable();
            $table->string('embassy')->nullable();
            $table->string('select_service')->nullable();
            $table->string('employee_status')->nullable();
            $table->string('contact_details')->nullable();
            $table->string('nationality')->nullable();
            $table->string('type_ticket')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('number_passport')->nullable();
            $table->string('country_passport')->nullable();
            $table->string('phone_number')->nullable();
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
        Schema::dropIfExists('order_service_form');
    }
};
