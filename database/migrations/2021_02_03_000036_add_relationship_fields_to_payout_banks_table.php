<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPayoutBanksTable extends Migration
{
    public function up()
    {
        Schema::table('payout_banks', function (Blueprint $table) {
            $table->unsignedBigInteger('payout_id')->nullable();
            $table->foreign('payout_id', 'payout_fk_3084463')->references('id')->on('payouts');
        });
    }
}
