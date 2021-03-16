<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProcessingColToSettlements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settlements', function (Blueprint $table) {
            $table->decimal('processing_fee', 15, 2)->default(0);
            $table->decimal('processing_rate', 15, 2)->default(0)->comment("%");
            $table->decimal('processing_fix', 15, 2)->default(0);
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
            //
        });
    }
}
