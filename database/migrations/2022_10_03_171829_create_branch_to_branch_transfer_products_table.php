<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchToBranchTransferProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_to_branch_transfer_products', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->index();
            $table->string('purchase_line_id')->nullable();
            $table->string('lot_number')->nullable();
            $table->string('purchase_price')->default(0);
            $table->string('sales_price')->default(0);
            $table->integer('pid')->index();
            $table->integer('variation_id')->default(0)->index();
            $table->double('quantity');
            $table->double('is_cartoon')->nullable()->default(0);
            $table->double('cartoon_quantity')->nullable()->default(0);
            $table->double('cartoon_amount')->nullable()->default(0);
            $table->string('discount')->default('no');
            $table->double('discount_amount')->default(0);
            $table->double('vat_amount')->nullable();
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
        Schema::dropIfExists('branch_to_branch_transfer_products');
    }
}
