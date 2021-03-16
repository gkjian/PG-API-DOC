<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPayoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payouts', function (Blueprint $table) {
            $table->string('bank_branch')->nullable()->default(null);
            $table->string('bank_city')->nullable()->default(null);
            $table->string('bank_state')->nullable()->default(null);
            $table->string('agent_name')->nullable()->default(null);
            $table->string('swift_code')->nullable()->default(null);
            $table->string('account_number')->nullable()->default(null);
            $table->string('iban_europe')->nullable()->default(null);
            $table->string('admin_remark')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payouts', function (Blueprint $table) {
            $table->dropColumn('bank_branch');
            $table->dropColumn('bank_city');
            $table->dropColumn('bank_state');
            $table->dropColumn('agent_name');
            $table->dropColumn('swift_code');
            $table->dropColumn('account_number');
            $table->dropColumn('iban_europe');
            $table->dropColumn('admin_remark');
        });
    }
}
