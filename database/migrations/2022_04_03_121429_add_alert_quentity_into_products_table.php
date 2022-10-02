<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlertQuentityIntoProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('alert_quantity')->nullable()->after('discount_amount');
            $table->string('is_variable')->default('simple')->after('discount_amount');
            $table->string('is_expiry')->default(0)->after('discount_amount');
            $table->string('warranty_id')->nullable()->after('discount_amount');
            $table->string('is_warranty')->default(0)->after('discount_amount');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
