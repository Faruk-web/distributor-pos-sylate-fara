<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->index();
            $table->mediumText('p_name');
            $table->integer('p_cat')->index();
            $table->integer('p_brand')->nullable()->index();
            $table->integer('p_unit_type')->index();
            $table->double('G_current_stock')->default(0);
            $table->integer('is_cartoon')->default(0);
            $table->double('cartoon_quantity')->default(0);
            $table->double('cartoon_purchase_price')->default(0);
            $table->double('cartoon_sales_price')->default(0);
            $table->string('image')->nullable();
            $table->double('purchase_price');
            $table->double('selling_price');
            $table->string('barCode')->nullable();
            $table->mediumText('p_description')->nullable();
            $table->string('discount')->nullable();
            $table->double('discount_amount')->nullable();
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('products');
    }
}
