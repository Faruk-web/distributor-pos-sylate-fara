<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_number')->unique();
            $table->string('shop_id')->index();
            $table->string('supplier_code')->index();
            $table->integer('user_id');
            $table->string('paymentBy');
            $table->double('due')->default(0);
            $table->double('paid')->default(0);
            $table->string('cheque_or_mfs_account')->nullable();
            $table->string('cheque_num')->nullable();
            $table->string('cheque_date')->nullable();
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
        Schema::dropIfExists('supplier_payments');
    }
}
