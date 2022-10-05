<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchToSRproductsTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_to_s_rproducts_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->index();
            $table->integer('user_id')->index();
            $table->string('invoice_id')->index();
            $table->integer('sender_branch_id')->index();
            $table->integer('sr_id')->index();
            $table->double('total_gross')->default(0);
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('branch_to_s_rproducts_transfers');
    }
}
