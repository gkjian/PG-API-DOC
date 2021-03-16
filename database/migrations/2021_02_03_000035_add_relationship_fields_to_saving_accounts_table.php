<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSavingAccountsTable extends Migration
{
    public function up()
    {
        Schema::table('saving_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id', 'currency_fk_3084680')->references('id')->on('currencies');
        });
    }
}
