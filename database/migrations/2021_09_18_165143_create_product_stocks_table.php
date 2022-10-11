<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->index();
            $table->integer('purchase_line_id')->index();
            $table->string('lot_number');
            $table->integer('branch_id')->index();
            $table->integer('pid')->index();
            $table->integer('variation_id')->nullable()->index();
            $table->string('purchase_price')->nullable();
            $table->string('sales_price')->nullable()->index();
            $table->string('discount')->default('no')->index();
            $table->string('discount_amount')->default(0)->index();
            $table->string('vat')->default(0);
            $table->double('stock')->default(0)->index();
            $table->integer('is_cartoon')->default(0);
            $table->double('cartoon_quantity')->default(0);
            $table->double('cartoon_amount')->default(0);
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
        Schema::dropIfExists('product_stocks');
    }
}
