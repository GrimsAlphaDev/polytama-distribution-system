<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'marketing'],
            ['name' => 'transporter'],
            ['name' => 'driver'],
            ['name' => 'logistik'],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }
    }
}
