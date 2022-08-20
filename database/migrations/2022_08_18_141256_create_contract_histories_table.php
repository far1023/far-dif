<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contract_histories', function (Blueprint $table) {
			$table->id();
			$table->string('contract_no');
			$table->unsignedBigInteger('employee_id');
			$table->string('position');
			$table->string('division');
			$table->date('start');
			$table->date('end');
			$table->unsignedBigInteger('basic_salary');
			$table->timestamps();

			$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('contract_histories');
	}
};
