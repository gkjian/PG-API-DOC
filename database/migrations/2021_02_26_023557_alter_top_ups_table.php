<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTopUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('top_ups', function (Blueprint $table) {
            $table->timestamp('user_update_time')->nullable();
            $table->timestamp('admin_approval_time')->nullable();
            $table->timestamp('expire_time')->nullable();
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
            $table->dropColumn('user_update_time');
            $table->dropColumn('admin_approval_time'); 
            $table->dropColumn('expire_time')->nullable();
        });
    }
}
