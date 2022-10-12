<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffInOutDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_in_out_details', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id');
            $table->string('staff_id');
            $table->string('date');
            $table->string('time')->nullable();
            $table->string('access_id')->nullable();
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
        Schema::dropIfExists('staff_in_out_details');
    }
}
