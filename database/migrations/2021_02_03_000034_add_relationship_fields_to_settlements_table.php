<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSettlementsTable extends Migration
{
    public function up()
    {
        Schema::table('settlements', function (Blueprint $table) {
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->foreign('merchant_id', 'merchant_fk_3084468')->references('id')->on('merchants');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id', 'bank_fk_3084497')->references('id')->on('settlement_banks');
        });
    }
}
