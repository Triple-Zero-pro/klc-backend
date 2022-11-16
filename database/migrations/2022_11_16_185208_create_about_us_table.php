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
        Schema::create('about_us', function (Blueprint $table) {
            $table->integer('id')->default(1);
            $table->string('logo')->nullable();
            $table->string('phone')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('location')->nullable();
            $table->string('address_ar')->nullable();
            $table->string('address_en')->nullable();
            $table->text('aboutUs_ar')->nullable();
            $table->text('aboutUs_en')->nullable();
            $table->text('terms_condition_ar')->nullable();
            $table->text('terms_condition_en')->nullable();
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
        Schema::dropIfExists('about_us');
    }
};
