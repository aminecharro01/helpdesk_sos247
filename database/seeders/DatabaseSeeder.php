<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Seeder des utilisateurs par défaut (admin, agent, superviseur, client)
        $this->call(DefaultUsersSeeder::class);

        // Ajout du seeder des rôles et permissions
        $this->call(RolePermissionSeeder::class);
    }
}
