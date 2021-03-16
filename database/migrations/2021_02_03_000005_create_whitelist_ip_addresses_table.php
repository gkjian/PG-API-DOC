<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhitelistIpAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('whitelist_ip_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip_address')->nullable();
            $table->string('status')->nullable()->comment('0=Enabled, 1=Disabled');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
