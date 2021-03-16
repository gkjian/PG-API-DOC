<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('balances', function (Blueprint $table) {
            $table->decimal('processing_fee', 10, 2)->default(0);
            $table->decimal('processing_rate', 10, 2)->default(0)->comment("%");
            $table->decimal('processing_fix', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('balances', function (Blueprint $table) {
            $table->dropColumn('processing_fee');
            $table->dropColumn('processing_rate');
            $table->dropColumn('processing_fix');
        });
    }
}
