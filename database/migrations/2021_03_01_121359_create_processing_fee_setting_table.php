<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessingFeeSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_processing_fee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gate_id')->nullable();
            $table->foreign('gate_id')->references('id')->on('products');
            $table->tinyInteger('fee_type')->default(0)->comment('0=fix, 1=rate');
            $table->tinyInteger('type')->default(0)->comment('0=topup 1=payout 2=settlement 3=deposit');
            $table->integer('value')->nullable();
            $table->decimal('range_min')->nullable();
            $table->decimal('range_max')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=Active, 1=Inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
