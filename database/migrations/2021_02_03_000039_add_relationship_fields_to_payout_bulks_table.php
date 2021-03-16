<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPayoutBulksTable extends Migration
{
    public function up()
    {
        Schema::table('payout_bulks', function (Blueprint $table) {
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->foreign('merchant_id', 'merchant_fk_3084402')->references('id')->on('merchants');
        });
    }
}
