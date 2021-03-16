<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementsTable extends Migration
{
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('status')->nullable()->comment('0=Pending, 1=Completed, 2=Failed, 3=Rejected');
            $table->string('remark')->nullable();
            // $table->string('transaction')->nullable();
            $table->string('document_no')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
