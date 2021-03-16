<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToWhitelistIpAddressesTable extends Migration
{
    public function up()
    {
        Schema::table('whitelist_ip_addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('gate_id')->nullable();
            $table->foreign('gate_id', 'gate_fk_3084703')->references('id')->on('products');
        });
    }
}
