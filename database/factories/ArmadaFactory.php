<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Armada>
 */
class ArmadaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Mitsubishi Canter FE SHDX', 'Isuzu ELF', 'Mitsubishi Colt FE SHD', 'Hino Ranger Cargo FG', 'Toyota Dyna', 'Hino Dutro Cargo 130 MD', 'Mercedes Benz Axor', 'Hino Ranger Dump FM 260 JD']),
            'type' => $this->faker->randomElement(['Engkel', 'Gandeng', 'Tronton']),
            'brand' => $this->faker->randomElement(['Hino', 'Mitsubishi', 'Mercedes Benz']),
            'year' => $this->faker->numberBetween(2010, 2021),
            'condition' => $this->faker->randomElement(['Baik']),
            'license_plate' => 'e ' . $this->faker->unique()->randomNumber(6, true) . ' ' . $this->faker->randomLetter() . $this->faker->randomLetter(),
            'max_load' => $this->faker->numberBetween(1000, 10000),
            'user_id' => $this->faker->numberBetween(2, 3),
            'status' => $this->faker->randomElement(['Available']),
        ];
    }
}
