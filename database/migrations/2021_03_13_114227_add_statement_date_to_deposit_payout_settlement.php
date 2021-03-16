<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatementDateToDepositPayoutSettlement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('top_ups', function (Blueprint $table) {
            $table->date('statement_date')->nullable();
        });

        Schema::table('settlements', function (Blueprint $table) {
            $table->date('statement_date')->nullable();
        });

        Schema::table('payouts', function (Blueprint $table) {
            $table->date('statement_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('top_ups', function (Blueprint $table) {
            $table->dropColumn('statement_date');
        });

        Schema::table('settlements', function (Blueprint $table) {
            $table->dropColumn('statement_date');
        });

        Schema::table('payouts', function (Blueprint $table) {
            $table->dropColumn('statement_date');
        });
    }
}
