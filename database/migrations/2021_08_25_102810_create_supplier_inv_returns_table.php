<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierInvReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_inv_returns', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id')->index();
            $table->string('supp_invoice_id')->unique()->index();
            $table->integer('supplier_id')->index();
            $table->double('total_gross');
            $table->double('supp_Due');
            $table->mediumText('note')->nullable();
            $table->integer('how_many_times_edited');
            $table->string('date');
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
        Schema::dropIfExists('supplier_inv_returns');
    }
}
