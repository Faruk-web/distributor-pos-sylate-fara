<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsRechargeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_recharge_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->index();
            $table->string('user_id')->index();
            $table->double('rechargeable_amount');
            $table->double('per_sms_price')->nullable();
            $table->double('sms_quantity')->nullable();
            $table->string('is_approved');
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
        Schema::dropIfExists('sms_recharge_requests');
    }
}
