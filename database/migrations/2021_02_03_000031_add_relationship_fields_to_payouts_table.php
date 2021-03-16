<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPayoutsTable extends Migration
{
    public function up()
    {
        Schema::table('payouts', function (Blueprint $table) {
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->foreign('merchant_id', 'merchant_fk_3084391')->references('id')->on('merchants');
            $table->unsignedBigInteger('bulk_id')->nullable();
            $table->foreign('bulk_id', 'bulk_fk_3084408')->references('id')->on('payout_bulks');
            $table->unsignedBigInteger('gate_id')->nullable();
            $table->foreign('gate_id', 'gate_fk_3084583')->references('id')->on('products');
        });
    }
}
