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
		Schema::create('employee_has_allowances', function (Blueprint $table) {
			$table->unsignedBigInteger('employee_id');
			$table->unsignedBigInteger('allowance_id');

			$table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
			$table->foreign('allowance_id')->references('id')->on('allowances')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('employee_has_allowances');
	}
};
