<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerifyToTopUpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('top_ups', function (Blueprint $table) {
            $table->tinyInteger('status_verify')->default(0)->comment("0:unverified , 1:verified , 2:KIV  , 3:Reconfirmed");
            // $table->smallInteger('status')->default(0)->comment('0=Initial, 1=Failed, 2=Rejected, 5=Pending, 7=Approved')->change();
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
            $table->dropColumn('status_verify');
        });
    }
}
