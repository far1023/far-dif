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
		Schema::create('allowances', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->unsignedInteger('percentage_on_basic')->nullable();
			$table->unsignedBigInteger('fix_amount')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('allowances');
	}
};
