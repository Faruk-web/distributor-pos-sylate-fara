<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_code')->unique()->index();
            $table->string('shop_name')->nullable();
            $table->string('shop_logo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('shop_website')->nullable();
            $table->string('start_date')->nullable();
            $table->string('renew_date')->nullable();
            $table->string('trial_status')->default('running');
            $table->string('trial_end_date')->nullable();
            $table->string('office_start_time')->nullable();
            $table->string('office_end_time')->nullable();
            $table->string('is_active')->default(1);
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
        Schema::dropIfExists('shop_settings');
    }
}
