<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_products', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->index();
            $table->string('lot_number')->nullable()->index();
            $table->string('purchase_price')->default(0);
            $table->integer('product_id')->index();
            $table->integer('variation_id')->default(0)->index();
            $table->double('quantity');
            $table->string('delivered_quantity')->nullable()->default(0);
            $table->integer('is_cartoon')->nullable()->default(0);
            $table->double('cartoon_quantity')->nullable()->default(0);
            $table->double('cartoon_amount')->nullable()->default(0);
            $table->double('price');
            $table->string('discount')->default('no');
            $table->double('discount_amount')->default(0);
            $table->double('discount_in_tk')->default(0);
            $table->double('vat_amount')->nullable();
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
        Schema::dropIfExists('ordered_products');
    }
}
