<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavingAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('saving_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->integer('daily_limit')->nullable()->comment('times per day');
            $table->decimal('daily_amount', 15, 2)->nullable();
            $table->decimal('transaction_limit', 15, 2)->nullable();
            $table->string('bank_id')->unique();
            $table->string('status')->nullable()->comment('0=Enabled, 1=Disabled');
            $table->timestamps();
            $table->softDeletes();
            $table->decimal('total_credit', 15, 2)->nullable();
        });
    }
}
