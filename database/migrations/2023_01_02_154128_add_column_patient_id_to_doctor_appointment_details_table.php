<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPatientIdToDoctorAppointmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_appointment_details', function (Blueprint $table) {
            $table->integer('patient_id');
            $table->foreign('patient_id')->references('id')->on('patient_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_appointment_details', function (Blueprint $table) {
            $table->dropColumn('patient_id');
        });
    }
}
