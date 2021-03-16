<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBalancesTable extends Migration
{
    public function up()
    {
        Schema::table('balances', function (Blueprint $table) {
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->foreign('merchant_id', 'merchant_fk_3084537')->references('id')->on('merchants');
            $table->unsignedBigInteger('gate_id')->nullable();
            $table->foreign('gate_id', 'gate_fk_3084584')->references('id')->on('products');
            $table->unsignedBigInteger('saving_account_id')->nullable();
            $table->foreign('saving_account_id')->references('id')->on('saving_accounts');
            $table->unsignedBigInteger('settlement_bank_id')->nullable();
            $table->foreign('settlement_bank_id')->references('id')->on('settlement_banks');
        });
    }
}
