<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToGateSavingAccountsTable extends Migration
{
    public function up()
    {
        Schema::table('gate_saving_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('gate_id')->nullable();
            $table->foreign('gate_id', 'gate_fk_3084691')->references('id')->on('products');
            $table->unsignedBigInteger('saving_account_id')->nullable();
            $table->foreign('saving_account_id', 'saving_account_fk_3084692')->references('id')->on('saving_accounts');
        });
    }
}
