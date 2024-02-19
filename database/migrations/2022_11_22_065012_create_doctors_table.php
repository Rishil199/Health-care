<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('clinic_id');
            $table->string('name', 90);
            $table->string('email', 60)->unique();
            $table->string('phone_no', 15);
            $table->string('address', 191);
            $table->string('latitude', 15);
            $table->string('logitude', 15);
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
        Schema::dropIfExists('doctors');
    }
}
