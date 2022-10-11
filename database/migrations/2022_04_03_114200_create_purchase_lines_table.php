<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_lines', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->index();
            $table->string('branch_id')->index();
            $table->string('invoice_id')->index();
            $table->integer('product_id')->index();
            $table->string('purchase_price')->default(0);
            $table->string('sales_price')->default(0);
            $table->string('discount')->default('no');
            $table->string('discount_amount')->default(0);
            $table->string('vat')->default(0);
            $table->integer('lot_number')->index()->nullable();
            $table->string('mfg_date')->nullable();
            $table->string('exp_date')->nullable();
            $table->integer('warranty_id')->nullable();
            $table->string('warranty_period')->nullable();
            $table->string('variation_id')->nullable();
            $table->string('imei_number')->nullable();
            $table->string('quantity')->default(0);
            $table->integer('is_cartoon')->default(0);
            $table->double('cartoon_quantity')->default(0);
            $table->double('cartoon_amount')->default(0);
            $table->longText('note')->nullable();
            $table->string('date')->nullable();
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
        Schema::dropIfExists('purchase_lines');
    }
}
