<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->index();
            $table->string('supp_invoice_id')->unique()->index();
            $table->integer('supplier_id')->index();
            $table->double('total_gross')->default(0);
            $table->double('pre_due')->default(0);
            $table->double('others_crg')->nullable();
            $table->double('paid')->default(0);
            $table->mediumText('note')->nullable();
            $table->string('supp_voucher_num');
            $table->string('place');
            $table->string('branch_id')->nullable()->index();
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
        Schema::dropIfExists('supplier_invoices');
    }
}
