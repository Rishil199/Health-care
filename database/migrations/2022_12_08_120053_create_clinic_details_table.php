<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('clinic_id');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->string('address', 191);
            $table->string('latitude', 15);
            $table->string('logitude', 15);
            $table->boolean('is_main_branch')->default(false)->comment('1 - yes, 0 - no');
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
        Schema::dropIfExists('clinic_details');
    }
}
