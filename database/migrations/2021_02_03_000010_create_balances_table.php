<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalancesTable extends Migration
{
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('debit', 15, 2)->nullable();
            $table->decimal('credit', 15, 2)->nullable();
            $table->string('type')->nullable()->comment('0=Deposit, 1=Top Up, 2=Payout, 3=Settlement, 4=Merchant Processing Fee, 5=Partner Processing Fee');
            $table->string('status')->nullable()->comment('0=Completed, 1=Canceled, 2=Canceled and Refund');
            // $table->string('transaction')->nullable();
            $table->string('document_no')->nullable();
            $table->string('remark')->nullable();
            $table->string('settlement_status')->nullable()->comment('0=Pending, 1=Completed');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('ref_id')->nullable();
        });
    }
}
