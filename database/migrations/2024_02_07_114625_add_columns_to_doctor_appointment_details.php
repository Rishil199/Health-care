<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('doctor_appointment_details', function (Blueprint $table) {
            $table->string('prescription');
            $table->decimal('weight',5,2)->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('dietplan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_appointment_details', function (Blueprint $table) {
            $table->dropColumn('prescription');
            $table->dropColumn('weight');
            $table->dropColumn('blood_pressure');
            $table->dropColumn('dietpan');
            
        });
    }
};
