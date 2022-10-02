<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGodownStockOutInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('godown_stock_out_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->index();
            $table->integer('user_id')->index();
            $table->string('invoice_id')->index();
            $table->integer('branch_id')->index();
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('godown_stock_out_invoices');
    }
}
