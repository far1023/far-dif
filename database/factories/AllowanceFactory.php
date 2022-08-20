<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Allowance>
 */
class AllowanceFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		$percentage_on_basic = $fix_amount = 0;

		if (rand(0, 1)) {
			$percentage_on_basic = $this->faker->numberBetween(0, 100);
		} else {
			$fix_amount = $this->faker->numberBetween(100000, 1000000);
		}

		return [
			'name' => $this->faker->unique()->word,
			'percentage_on_basic' => $percentage_on_basic,
			'fix_amount' => $fix_amount,
		];
	}
}
