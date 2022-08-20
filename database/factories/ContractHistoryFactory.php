<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContractHistory>
 */
class ContractHistoryFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		$end = $this->faker->date('Y-m-d', 'now');
		$start = $this->faker->date('Y-m-d', $end);
		return [
			'contract_no' => str_replace("-", "", $start) . $this->faker->unique()->randomNumber,
			'employee_id' => $this->faker->numberBetween(1, 10),
			'position' => $this->faker->jobTitle,
			'division' => $this->faker->city,
			'start' => $start,
			'end' => $end,
			'basic_salary' => $this->faker->numberBetween(1000000, 10000000)
		];
	}
}
