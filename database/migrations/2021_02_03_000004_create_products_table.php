<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('secret_key')->nullable();
            $table->string('product_key')->nullable();
            $table->string('status')->nullable()->comment('0=Enabled, 1=Disabled');
            $table->string('description')->nullable();
            $table->string('callback_url')->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('gate_id')->unique();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('daily_limit')->nullable()->comment('times per day');
            $table->decimal('daily_amount', 15, 2)->nullable();
            $table->text('processing_fee')->nullable();
            $table->decimal('current_credit', 15, 2);
            $table->decimal('freeze_credit', 15, 2);
        });
    }
}
