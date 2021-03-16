<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallbackTopupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('callback_topups', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('merchant_id');
			$table->integer('gate_id');
			// $table->string('transaction');
            $table->string('document_no')->nullable();
			$table->string('client_transaction');
			$table->integer('amount');
			$table->integer('status')->comment('0 new, 1 completed');
			$table->integer('return_status');
			$table->integer('throttle');
			$table->text('callback_url');
			$table->text('redirect_url');
			$table->timestamps(6);
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('callback_topups');
	}

}
