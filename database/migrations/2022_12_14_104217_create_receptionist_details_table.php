<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceptionistDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receptionist_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('clinic_id');
            $table->string('gender');
            $table->date('birth_date')->nullable()->default('1970-01-01');
            $table->string('qualification')->nullable()->default('N/A');
            $table->string('experience')->nullable()->default('N/A');
            $table->boolean('status')->default(false)->comment('1 - active, 0 - not  active');
            $table->string('latitude', 15);
            $table->string('logitude', 15);
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
        Schema::dropIfExists('receptionist_details');
    }
}
