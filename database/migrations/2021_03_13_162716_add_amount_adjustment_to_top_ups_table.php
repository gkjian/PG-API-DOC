<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountAdjustmentToTopUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('top_ups', function (Blueprint $table) {
            $table->decimal('amount_adjustment', 15, 2)->default(0);
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
            $table->dropColumn('amount_adjustment');
        });
    }
}
