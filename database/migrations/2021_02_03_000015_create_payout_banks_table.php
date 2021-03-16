<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutBanksTable extends Migration
{
    public function up()
    {
        Schema::create('payout_banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_currency')->nullable();
            $table->string('bank_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
