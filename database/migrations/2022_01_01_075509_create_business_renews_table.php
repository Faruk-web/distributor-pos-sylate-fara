<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessRenewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_renews', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->index();
            $table->integer('renew_by')->index();
            $table->double('amount')->nullable();
            $table->string('paymentBy')->nullable();
            $table->string('renew_date');
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
        Schema::dropIfExists('business_renews');
    }
}
