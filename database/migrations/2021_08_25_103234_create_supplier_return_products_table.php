<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierReturnProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_return_products', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->index();
            $table->string('supp_invoice_id')->unique();
            $table->integer('how_many_times_edited');
            $table->double('product_id')->index();
            $table->double('variation_id')->index();
            $table->double('quantity')->default(0);
            $table->integer('is_cartoon')->default(0);
            $table->double('cartoon_quantity')->default(0);
            $table->double('cartoon_amount')->default(0);
            $table->double('price')->default(0);
            $table->double('total_price')->default(0);
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
        Schema::dropIfExists('supplier_return_products');
    }
}
