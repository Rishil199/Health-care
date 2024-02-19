<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('clinic_id')->unsigned();
            $table->string('address', 191);
            $table->string('latitude', 15);
            $table->string('logitude', 15);
            $table->date('birth_date')->nullable()->default('1970-01-01');
            $table->string('gender');
            $table->string('degree')->nullable()->default('N/A');
            $table->string('experience')->nullable()->default('0');
            $table->boolean('status')->default(false)->comment('1 - active, 0 - not  active');
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
        Schema::dropIfExists('doctor_details');
    }
}
