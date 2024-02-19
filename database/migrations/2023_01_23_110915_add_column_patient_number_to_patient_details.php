<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPatientNumberToPatientDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_details', function (Blueprint $table) {
            $table->string('patient_number',100);
            $table->integer('receptionist_id')->nullable()->unsigned();
            $table->decimal('height',5,2)->nullable();
            $table->decimal('weight',5,2)->nullable();
            $table->string('blood_group')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->boolean('is_mediclaim_available')->nullable()->default(false);
            $table->string('relation')->nullable();
            $table->string('relative_name')->nullable();
            $table->string('emergency_contact')->nullable()->default('0');
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_details', function (Blueprint $table) {
            $table->dropColumn('receptionist_id');
            $table->dropColumn('height');
            $table->dropColumn('weight');
            $table->dropColumn('blood_group');
            $table->dropColumn('blood_pressure');
            $table->dropColumn('is_mediclaim_available');
            $table->dropColumn('relation');
            $table->dropColumn('relative_name');
            $table->dropColumn('emergency_contact');
        });
    }
}
