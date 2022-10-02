<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_num')->unique()->index();
            $table->integer('shop_id')->index();
            $table->integer('user_id')->index();
            $table->integer('lender_id')->index();
            $table->string('paid_or_received');
            $table->string('cash_or_cheque');
            $table->double('amount')->default(0);
            $table->integer('bank_id')->nullable();
            $table->string('account_num')->nullable();
            $table->string('cheque_num')->nullable();
            $table->string('lender_bank_name')->nullable();
            $table->string('cheque_diposite_date')->nullable();
            $table->string('cheque_date')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('loan_transactions');
    }
}
