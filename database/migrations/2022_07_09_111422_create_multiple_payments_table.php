<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiplePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multiple_payments', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->index();
            $table->string('customer_id')->index();
            $table->string('branch_id')->index();
            $table->string('invoice_id')->index();
            $table->string('paid_amount')->default(0);
            $table->string('payment_type')->nullable();
            $table->longText('info')->nullable();
            $table->string('deposit_to')->nullable();
            $table->string('custom_field')->nullable();
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
        Schema::dropIfExists('multiple_payments');
    }
}
