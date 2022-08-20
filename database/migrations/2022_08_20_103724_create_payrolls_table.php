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
		Schema::create('payrolls', function (Blueprint $table) {
			$table->id();
			$table->string('payroll_no', 15)->unique();
			$table->integer('month');
			$table->integer('year');
			$table->unsignedBigInteger('employee_id');
			$table->unsignedBigInteger('salary_amount');
			$table->unsignedBigInteger('allowance_amount')->default(0);
			$table->unsignedBigInteger('take_home_pay');
			$table->dateTime('created_at');
			$table->unsignedBigInteger('created_by');

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
		Schema::dropIfExists('payrolls');
	}
};
