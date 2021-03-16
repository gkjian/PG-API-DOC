<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable()->comment('0=Pending, 1=Completed, 2=Failed, 3=Rejected, 4=Cancelled');
            $table->string('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
