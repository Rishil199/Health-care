<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorAppointmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_appointment_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('appointment_date')->nullable()->default('1970-01-01');
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
        Schema::dropIfExists('doctor_appointment_details');
    }
}
