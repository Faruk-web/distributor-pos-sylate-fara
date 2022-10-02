<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointRedeemInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_redeem_infos', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->index();
            $table->string('customer_id')->index();
            $table->string('point_redeem_rate')->nullable();
            $table->string('customer_point')->nullable();
            $table->string('converted_wallet_amount')->nullable();
            $table->string('note')->nullable();
            $table->string('user_id')->nullable();
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
        Schema::dropIfExists('point_redeem_infos');
    }
}
