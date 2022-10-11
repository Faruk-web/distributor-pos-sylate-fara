<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_trackers', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->index();
            $table->integer('purchase_line_id')->index()->nullable();
            $table->integer('lot_number')->index()->nullable();
            $table->string('purchase_price')->default(0);
            $table->string('total_purchase_price')->default(0);
            $table->double('sales_price')->default(0);
            $table->integer('variation_id')->default(0);
            $table->integer('branch_id')->index()->nullable();
            $table->integer('product_id')->index();
            $table->double('quantity')->default(0);
            $table->integer('is_cartoon')->nullable()->default(0);
            $table->double('cartoon_quantity')->nullable()->default(0); // EX. 20 = 1 cartoon
            $table->double('cartoon_amount')->nullable()->default(0); // Ex. 10 cartoons
            $table->double('price')->default(0);
            $table->string('discount')->default('no');
            $table->string('discount_amount')->default(0);
            $table->string('discount_in_tk')->default(0);
            $table->string('vat')->default(0);
            $table->string('vat_in_tk')->default(0);
            $table->double('total_price')->default(0);
            $table->integer('status');
            $table->string('product_form')->nullable();
            $table->string('invoice_id')->index();
            $table->string('supplier_id')->index()->nullable();
            $table->mediumText('note')->nullable();
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
        Schema::dropIfExists('product_trackers');
    }
}
