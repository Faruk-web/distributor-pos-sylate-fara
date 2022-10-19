<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamageProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damage_products', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->index();
            $table->integer('branch_id')->index();
            $table->integer('pid')->index();
            $table->integer('variation_id')->default(0)->index();
            $table->double('quantity');
            $table->string('is_cartoon')->nullable()->default(0);
            $table->string('cartoon_quantity')->nullable()->default(0);
            $table->string('cartoon_amount')->nullable()->default(0);
            $table->double('purchase_price');
            $table->double('selling_price');
            $table->mediumText('reason')->nullable();
            $table->date('date');
            $table->integer('created_by')->nullable()->index();
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
        Schema::dropIfExists('damage_products');
    }
}
