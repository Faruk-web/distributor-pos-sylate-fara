<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderReturnPorductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_return_porducts', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->index();
            $table->string('lot_number')->nullable()->index();
            $table->string('purchase_price')->default(0);
            $table->string('return_or_exchange')->default('r');
            $table->string('how_many_times_edited')->nullable();
            $table->integer('product_id')->index();
            $table->integer('variation_id')->index()->default(0);
            $table->double('quantity')->default(0);
            $table->integer('is_cartoon')->default(0);
            $table->double('cartoon_quantity')->nullable()->default(0);
            $table->double('cartoon_amount')->nullable()->default(0);
            $table->double('price')->default(0);
            $table->string('discount')->default('no');
            $table->double('discount_amount')->default(0);
            $table->string('vat')->nullable();
            $table->double('total_price');
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
        Schema::dropIfExists('order_return_porducts');
    }
}
