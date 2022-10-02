<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_num')->unique()->index();
            $table->integer('shop_id')->index();
            $table->integer('user_id')->index();
            $table->integer('ledger_head')->index();
            $table->string('cash_or_cheque');
            $table->double('amount');
            $table->integer('bank_id')->nullable();
            $table->string('cheque_num')->nullable();
            $table->string('cheque_date')->nullable();
            $table->string('voucher')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('expense_transactions');
    }
}
