<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSettlementBanksTable extends Migration
{
    public function up()
    {
        Schema::table('settlement_banks', function (Blueprint $table) {
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->foreign('merchant_id', 'merchant_fk_3084489')->references('id')->on('merchants');
        });
    }
}
