<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPointEarnRateToShopSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            $table->string('is_active_customer_points')->nullable()->after('vat_type');
            $table->double('point_earn_rate')->nullable()->after('vat_type');
            $table->double('point_redeem_rate')->nullable()->after('vat_type');
			$table->string('minimum_purchase_to_get_point')->default(0)->after('point_earn_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_settings', function (Blueprint $table) {
            //
        });
    }
}
