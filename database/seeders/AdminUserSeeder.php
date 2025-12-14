<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@jamin.nl',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
    }
}
