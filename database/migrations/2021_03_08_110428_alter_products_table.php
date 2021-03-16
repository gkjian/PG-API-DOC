<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('current_credit', 10, 2)->default(0)->change();
            $table->decimal('freeze_credit', 10, 2)->default(0)->change();
            $table->string('status')->default('0')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('current_credit');
            $table->dropColumn('freeze_credit');
            $table->dropColumn('status');
        });
    }
}
