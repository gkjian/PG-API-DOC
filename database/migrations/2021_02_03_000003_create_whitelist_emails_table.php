<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhitelistEmailsTable extends Migration
{
    public function up()
    {
        Schema::create('whitelist_emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emaill')->nullable();
            $table->string('status')->nullable()->comment('0=Enabled, 1=Disabled');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
