<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->string('person_incharge_name');
            $table->string('contact');
            $table->tinyInteger('status')->default(0)->comment('0=Active, 1=Inactive');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
