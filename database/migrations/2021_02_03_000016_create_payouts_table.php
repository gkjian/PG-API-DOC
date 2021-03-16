<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration
{
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('status')->nullable()->comment('0=Pending, 1=Completed, 2=Failed, 3=Reject');
            $table->string('remark')->nullable();
            // $table->string('transaction')->nullable();
            $table->string('document_no')->nullable();
            $table->string('callback_url')->nullable();
            $table->unsignedBigInteger('saving_account_id')->nullable();
            $table->foreign('saving_account_id')->references('id')->on('saving_accounts');
            $table->string('bank_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
