<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementBanksTable extends Migration
{
    public function up()
    {
        Schema::create('settlement_banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('status')->nullable()->comment('0=Enabled, 1=Disabled');
            $table->string('bank_code')->unique()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
