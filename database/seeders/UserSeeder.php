<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get userfactory
        $marketing = [
            'nik' => '123456',
            'name' => fake()->name(),
            'email' => fake()->unique()->email(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => 1,
            'transporter_id' => null,
        ];

        $transporter = [
            'nik' => fake()->unique()->randomNumber(6, true),
            'name' => fake()->name(),
            'email' => fake()->unique()->email(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => 2,
            'transporter_id' => null,
        ];

        $driver = [
            'nik' => fake()->unique()->randomNumber(6, true),
            'name' => fake()->name(),
            'email' => fake()->unique()->email(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => 3,
            'transporter_id' => 2,
        ];

        $driver2 = [
            'nik' => fake()->unique()->randomNumber(6, true),
            'name' => fake()->name(),
            'email' => fake()->unique()->email(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => 3,
            'transporter_id' => 2,
        ];


        User::create($marketing);
        User::create($transporter);
        User::create($driver);
        User::create($driver2);
    }
}
