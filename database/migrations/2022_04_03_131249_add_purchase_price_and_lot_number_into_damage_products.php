<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchasePriceAndLotNumberIntoDamageProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('damage_products', function (Blueprint $table) {
            $table->integer('purchase_line_id')->nullable()->after('shop_id');
            $table->integer('lot_number')->nullable()->after('purchase_line_id');
            $table->string('discount')->default('no')->after('selling_price');
            $table->string('discount_amount')->default(0)->after('discount');
            $table->string('vat')->default(0)->after('discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('damage_products', function (Blueprint $table) {
            //
        });
    }
}
