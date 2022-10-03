<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchToBranchTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_to_branch_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->index();
            $table->integer('user_id')->index();
            $table->string('invoice_id')->index();
            $table->integer('sender_branch_id')->index();
            $table->integer('receiver_branch_id')->index();
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
        Schema::dropIfExists('branch_to_branch_transfers');
    }
}
