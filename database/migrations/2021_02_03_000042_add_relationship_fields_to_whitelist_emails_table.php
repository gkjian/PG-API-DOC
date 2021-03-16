<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToWhitelistEmailsTable extends Migration
{
    public function up()
    {
        Schema::table('whitelist_emails', function (Blueprint $table) {
            $table->unsignedBigInteger('gate_id')->nullable();
            $table->foreign('gate_id', 'gate_fk_3098875')->references('id')->on('products');
        });
    }
}
