<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Allowance;
use App\Models\ContractHistory;
use App\Models\Employee;
use App\Models\EmployeeHasAllowance;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		Allowance::factory()->count(5)->create();
		Employee::factory()->count(10)->create();
		ContractHistory::factory()->count(15)->create();

		for ($i = 1; $i <= 10; $i++) {
			$rand = rand(1, 5);
			for ($j = 0; $j <= $rand; $j++) {
				EmployeeHasAllowance::firstOrCreate([
					"employee_id" => $i,
					"allowance_id" => rand(1, 5)
				]);
			}
		}
	}
}
