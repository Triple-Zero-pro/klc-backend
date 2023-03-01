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
        Schema::create('service_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->boolean('from')->default(0);
            $table->boolean('to')->default(0);
            $table->boolean('appointment_date')->default(0);
            $table->boolean('appointment_time')->default(0);
            $table->boolean('image_front')->default(0);
            $table->boolean('image_back')->default(0);
            $table->boolean('image_ticket')->default(0);
            $table->boolean('image_passport')->default(0);
            $table->boolean('image_visa')->default(0);
            $table->boolean('image_office')->default(0);
            $table->boolean('gender')->default(0);
            $table->boolean('embassy')->default(0);
            $table->boolean('select_service')->default(0);
            $table->boolean('employee_status')->default(0);
            $table->boolean('contact_details')->default(0);
            $table->boolean('nationality')->default(0);
            $table->boolean('type_ticket')->default(0);
            $table->boolean('employee_name')->default(0);
            $table->boolean('number_passport')->default(0);
            $table->boolean('country_passport')->default(0);
            $table->boolean('phone_number')->default(0);
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
        Schema::dropIfExists('order_service_attributes');
    }
};
