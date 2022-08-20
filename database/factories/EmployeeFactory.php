<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		$genders = ["male", "female"];
		$gender = $genders[rand(0, 1)];

		return [
			'name' => $this->faker->unique()->name($gender),
			'pob' => $this->faker->city,
			'dob' => $this->faker->date,
			'gender' => $gender,
			'contact' => $this->faker->unique()->phoneNumber,
			'email' => $this->faker->unique()->safeEmail,
			'address' => $this->faker->unique()->address,
		];
	}
}
