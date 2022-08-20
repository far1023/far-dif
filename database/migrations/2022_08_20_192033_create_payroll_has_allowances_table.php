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
		Schema::create('payroll_has_allowances', function (Blueprint $table) {
			$table->string('payroll_no', 15);
			$table->string('allowance_name');
			$table->string('allowance_amount');

			$table->foreign('payroll_no')->references('payroll_no')->on('payrolls')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('payroll_has_allowances');
	}
};
