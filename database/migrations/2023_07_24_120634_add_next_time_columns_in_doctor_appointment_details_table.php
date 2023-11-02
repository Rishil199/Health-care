<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNextTimeColumnsInDoctorAppointmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_appointment_details', function (Blueprint $table) {
            $table->string('next_start_time', 50)->nullable()->change();
            $table->string('next_end_time', 50)->nullable()->change();
            $table->dateTime('next_date')->nullable();
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
            $table->string('next_start_time', 50)->change();
            $table->string('next_end_time', 50)->change();
            $table->dropColumn('next_date');
        });
    }
}
