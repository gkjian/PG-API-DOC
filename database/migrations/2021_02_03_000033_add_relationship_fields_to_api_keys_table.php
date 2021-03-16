<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToApiKeysTable extends Migration
{
    public function up()
    {
        Schema::table('api_keys', function (Blueprint $table) {
            $table->unsignedBigInteger('gate_id')->nullable();
            $table->foreign('gate_id', 'gate_fk_3084609')->references('id')->on('products');
        });
    }
}
