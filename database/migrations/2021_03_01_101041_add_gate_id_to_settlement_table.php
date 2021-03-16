<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGateIdToSettlementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settlements', function (Blueprint $table) {
            $table->unsignedBigInteger('gate_id')->nullable();
            $table->foreign('gate_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settlements', function (Blueprint $table) {
            $table->dropColumn('gate_id');
        });
    }
}
