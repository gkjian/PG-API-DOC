<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGateSavingAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('gate_saving_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('daily_limit')->nullable()->comment('times per day');
            $table->decimal('daily_amount', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
