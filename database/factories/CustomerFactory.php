<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->email(),
            'kota' => $this->faker->city,
            'alamat' => $this->faker->company . ', ' . $this->faker->streetAddress . ' ' . $this->faker->city . ' ' . $this->faker->state . ' ' . $this->faker->postcode,
            'no_telp' => $this->faker->phoneNumber,
            'created_at' => $this->faker->dateTimeBetween('2024-01-01', '2024-06-01'),
            'updated_at' => $this->faker->dateTimeBetween('2024-01-01', '2024-06-01'),
        ];
    }
}
