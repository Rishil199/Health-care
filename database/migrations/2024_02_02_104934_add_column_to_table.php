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
        Schema::table('patient_details', function (Blueprint $table) {
          $table->decimal('height',5,2)->nullable();
          $table->decimal('weight',5,2)->nullable();
          $table->string('blood_group')->nullable();
          $table->string('blood_pressure')->nullable();
          $table->boolean('is_mediclaim_available')->default(false);
          $table->string('relation')->nullable();
          $table->string('relative_name')->nullable();
          $table->string('emergency_contact')->nullable()->default('0');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_details', function (Blueprint $table) {
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
};
