<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchasePriceAndLotNumberIntoSupplierReturnProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplier_return_products', function (Blueprint $table) {
            $table->string('purchase_price')->nullable()->after('supp_invoice_id');
            $table->integer('lot_number')->nullable()->after('supp_invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplier_return_products', function (Blueprint $table) {
            //
        });
    }
}
