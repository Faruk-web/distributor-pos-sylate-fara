<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contras', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_number')->index();
            $table->integer('shop_id')->index();
            $table->integer('user_id')->index();
            $table->string('CTB_or_BTC')->index();
            $table->string('sender')->index();
            $table->string('receiver')->index();
            $table->double('contra_amount');
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('contras');
    }
}
