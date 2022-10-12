<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->index();
            $table->integer('branch_id')->index()->nullable();
            $table->integer('area_id')->index()->nullable();
            $table->integer('sr_id')->index();
            $table->string('invoice_id')->unique()->index();
            $table->integer('customer_id')->index();
            $table->string('total_gross');
            $table->string('vat')->default(0);
            $table->string('vat_in_tk')->default(0);
            $table->string('discount_status')->nullable();
            $table->double('discount_rate')->nullable();
            $table->double('discount_in_tk')->default(0);
            $table->string('pre_due')->nullable()->default(0);
            $table->string('others_crg')->default(0);
            $table->string('delivery_crg')->default(0);
            $table->string('invoice_total')->default(0);
            $table->string('payment_by')->nullable();
            $table->string('wallet_status')->default('no');
            $table->string('wallet_balance')->default(0);
            $table->string('total_for_point')->default(0);
            $table->string('point_earn_rate')->default(0);
            $table->string('wallet_point')->default(0);
            $table->double('paid_amount')->default(0);
            $table->string('change_amount')->nullable()->default(0);
            $table->mediumText('note')->nullable();
            $table->integer('delivery_man_id')->nullable();
            $table->mediumText('card_or_mfs')->default('no');
            $table->mediumText('cheque_or_mfs_acc')->nullable();
            $table->string('mfs_acc_type')->nullable();
            $table->string('cheque_bank')->nullable();
            $table->string('diposit_to')->nullable();
            $table->string('cheque_date')->nullable();
            $table->string('c_diposit_date')->nullable();
            $table->string('crm_id')->nullable()->index();
            $table->integer('sms_status')->nullable()->default(0);
            $table->date('date');
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
        Schema::dropIfExists('orders');
    }
}
