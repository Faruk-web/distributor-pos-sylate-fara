<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->index();
            $table->string('branch_name');
            $table->string('branch_address');
            $table->string('branch_phone_1');
            $table->string('branch_phone_2')->nullable();
            $table->string('branch_email')->nullable();
            $table->string('vat_status');
            $table->double('vat_rate')->nullable();
            $table->string('discount_type');
            $table->string('online_sell_status');
            $table->string('sell_note');
            $table->string('others_charge');
            $table->string('sms_status');
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
        Schema::dropIfExists('branch_settings');
    }
}
