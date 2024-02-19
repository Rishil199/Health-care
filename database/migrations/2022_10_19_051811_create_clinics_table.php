<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('clinic_id');
            $table->foreign('clinic_id')->unsigned();
            $table->string('name', 90);
            $table->string('email', 60)->unique();
            $table->string('phone_no', 15);
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
        Schema::dropIfExists('clinics');
    }
}
