<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->index();
            $table->integer('branch_id')->index();
            $table->string('invoice_id')->index();
            $table->integer('return_current_times');
            $table->integer('customer_id')->index();
            $table->double('total_gross')->default(0);
            $table->string('vat_status')->nullable();
            $table->string('discount_status');
            $table->double('discount_rate')->nullable();
            $table->double('others_crg')->nullable();
            $table->double('fine')->nullable();
            $table->double('refundAbleAmount');
            $table->double('currentDue');
            $table->double('paid')->default(0);
            $table->string('invoice_point')->default(0);
            $table->string('back_point')->default(0);
            $table->mediumText('note')->nullable();
            $table->string('date');
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
        Schema::dropIfExists('return_orders');
    }
}
