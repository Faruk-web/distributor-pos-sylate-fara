<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTakeCustomerDuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('take_customer_dues', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->index();
            $table->string('voucher_number')->index();
            $table->integer('user_id')->index();
            $table->integer('branch_id')->nullable()->index();
            $table->string('customer_code')->index();
            $table->string('paymentBy');
            $table->double('due');
            $table->double('received_amount');
            $table->string('cheque_or_mfs_account')->nullable();
            $table->string('cheque_date')->nullable();
            $table->string('cheque_bank_or_mfs_name')->nullable();
            $table->string('deposit_to')->nullable();
            $table->string('deposit_date')->nullable();
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
        Schema::dropIfExists('take_customer_dues');
    }
}
