<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->index();
            $table->string('branch_id')->nullable()->index();
            $table->integer('added_by');
            $table->string('for_what')->index();
            $table->string('track')->nullable();
            $table->string('refference')->index();
            $table->double('amount');
            $table->string('creadit_or_debit');
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
