<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTopUpsTable extends Migration
{
    public function up()
    {
        Schema::table('top_ups', function (Blueprint $table) {
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->foreign('merchant_id', 'merchant_fk_3084593')->references('id')->on('merchants');
            $table->unsignedBigInteger('gate_id')->nullable();
            $table->foreign('gate_id', 'gate_fk_3084594')->references('id')->on('products');
        });
    }
}
