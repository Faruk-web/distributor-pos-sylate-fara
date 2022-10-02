<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductWithVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_with_variations', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->index();
            $table->string('sku')->nullable();
            $table->integer('pid')->index();
            $table->integer('variation_list_id')->index();
            $table->double('purchase_price')->nullable();
            $table->double('selling_price')->nullable();
            $table->string('barCode')->nullable();
            $table->string('tax')->nullable();
            $table->string('discount')->nullable();
            $table->double('dicount_amount')->nullable();
            $table->integer('is_active')->default(1);
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
        Schema::dropIfExists('product_with_variations');
    }
}
