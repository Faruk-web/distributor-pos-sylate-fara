<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapitalTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capital_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_num')->unique()->index();
            $table->integer('shop_id')->index();
            $table->integer('user_id')->index();
            $table->integer('owner_id')->index();
            $table->string('add_or_withdraw');
            $table->string('cash_or_cheque');
            $table->double('amount');
            $table->integer('bank_id')->nullable();
            $table->string('account_num')->nullable();
            $table->string('cheque_num')->nullable();
            $table->string('owner_bank_name')->nullable();
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
        Schema::dropIfExists('capital_transactions');
    }
}
