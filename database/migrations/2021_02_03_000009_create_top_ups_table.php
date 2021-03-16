<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopUpsTable extends Migration
{
    public function up()
    {
        Schema::create('top_ups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('processing_fee', 15, 2)->nullable();
            // $table->string('transaction')->nullable();
            $table->string('document_no')->nullable();
            $table->string('client_transaction')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=Initial, 1=Failed, 2=Rejected, 3=Not Verify, 4=KIV, 5=Pending, 6=Verified, 7=Approved, 8=Reconfirmed');
            $table->string('remark')->nullable();
            $table->integer('freeze')->nullable();
            $table->text('signature')->nullable();
            $table->string('callback_url')->nullable();
            $table->string('redirect_url')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
