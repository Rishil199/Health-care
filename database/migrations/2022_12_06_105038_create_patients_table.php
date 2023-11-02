<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('clinic_id');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->integer('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->string('name', 90);
            $table->string('email', 60)->unique();
            $table->string('gender');
            $table->date('admit_date')->nullable()->default('1970-01-01');
            $table->string('disease_name')->nullable()->default('N/A');
            $table->string('prescription')->nullable()->default('N/A');
            $table->string('allergies')->nullable()->default('N/A');
            $table->string('illness')->nullable()->default('N/A');
            $table->string('exercise');
            $table->string('alchohol_consumption');
            $table->string('diet');
            $table->string('smoke');
            $table->string('phone_no', 15);
            $table->string('address');
            $table->string('latitude', 15);
            $table->string('logitude', 15);
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
        Schema::dropIfExists('patients');
    }
}
