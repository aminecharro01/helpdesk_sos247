<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DefaultUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Agent',
                'email' => 'agent@test.com',
                'role' => 'agent',
            ],
            [
                'name' => 'Superviseur',
                'email' => 'superviseur@test.com',
                'role' => 'superviseur',
            ],
            [
                'name' => 'Client',
                'email' => 'client@test.com',
                'role' => 'client', // "collaborateur" mappé sur le rôle client
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => $data['role'],
                ]
            );
        }
    }
}
