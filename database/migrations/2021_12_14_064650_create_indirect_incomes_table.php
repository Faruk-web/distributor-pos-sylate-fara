<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndirectIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indirect_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_num')->index();
            $table->integer('shop_id')->index();
            $table->integer('user_id')->index();
            $table->integer('ledger_head')->index();
            $table->string('cash_or_cheque');
            $table->double('amount')->default(0);
            $table->integer('bank_id')->nullable();
            $table->string('cheque_or_mfs_acc_num')->nullable();
            $table->string('cheque_or_mfs_acc_bank')->nullable();
            $table->string('cheque_date')->nullable();
            $table->string('cheque_deposit_date')->nullable();
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
        Schema::dropIfExists('indirect_incomes');
    }
}
