<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiseaseNameColumnToDoctorAppointmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_appointment_details', function (Blueprint $table) {
            $table->string('disease_name', 50)->nullable();
            $table->time('time_start');
            $table->time('time_end');
            $table->integer('patient_id');
            $table->foreign('patient_id')->references('id')->on('patient_details');
            $table->string('next_end_time', 50)->nullable();
            $table->string('next_start_time', 50)->nullable();
            $table->integer('clinic_id')->nullable();
            $table->integer('receptionist_id')->nullable();
            $table->integer('doctor_id')->nullable();
            $table->softDeletes();
            $table->integer('created_by');
            $table->dateTime('next_date')->nullable();
            $table->string('prescription')->nullable();
            $table->decimal('weight',5,2)->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('dietplan')->nullable();
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
            $table->dropColumn('disease_name');
            $table->dropColumn('time_start');
            $table->time('time_end');
            $table->dropColumn('patient_id');
            $table->dropColumn('next_end_time');
            $table->dropColumn('next_start_time');
            $table->dropColumn('clinic_id');
            $table->dropColumn('receptionist_id');
            $table->dropColumn('doctor_id');
            $table->dropColumn('deleted_at');
            $table->dropColumn('created_by');
            $table->dropColumn('next_date');
            $table->dropColumn('prescription');
            $table->dropColumn('weight');
            $table->dropColumn('blood_pressure');
            $table->dropColumn('dietpan');
            

        });
    }
}
