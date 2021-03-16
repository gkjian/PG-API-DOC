<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSettlements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settlements', function (Blueprint $table) {
            $table->string('bank_branch')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->string('crypto_currency')->nullable();
            $table->string('crypto_wallet_address')->nullable();
            $table->unsignedBigInteger('saving_account_id')->nullable();
            $table->foreign('saving_account_id')->references('id')->on('saving_accounts');
            $table->decimal('submit_amount', 15, 2)->nullable();
            $table->decimal('amount_left', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settlements', function (Blueprint $table) {
            //
        });
    }
}
