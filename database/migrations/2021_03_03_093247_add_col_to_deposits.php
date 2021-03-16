<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToDeposits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->decimal('processing_fee', 15, 2)->default(0);
            $table->decimal('processing_rate', 15, 2)->default(0)->comment("%");
            $table->decimal('processing_fix', 15, 2)->default(0);
            $table->string('ip_address')->nullable();
            $table->datetime('processed_at')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->foreign('processed_by')->references('id')->on('admins');

            $table->string('document_no')->nullable();
            $table->string('client_transaction_id')->nullable();
            $table->unsignedBigInteger('gate_id')->nullable();
            $table->foreign('gate_id')->references('id')->on('products');
            $table->unsignedBigInteger('saving_account_id')->nullable();
            $table->foreign('saving_account_id')->references('id')->on('saving_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deposits', function (Blueprint $table) {
            //
        });
    }
}
