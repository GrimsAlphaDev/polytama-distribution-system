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
            'alamat' => $this->faker->address,
            'no_telp' => $this->faker->phoneNumber,
            // modify created and updated at to be a random month from january 2024 to june 2024
            'created_at' => $this->faker->dateTimeBetween('2024-01-01', '2024-06-30'),
            'updated_at' => $this->faker->dateTimeBetween('2024-01-01', '2024-06-30'),
        ];
    }
}
