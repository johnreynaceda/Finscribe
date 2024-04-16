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

       User::create([
        'name' => 'Stakeholder',
        'email' => 'stakeholder@gmail.com',
        'password' => bcrypt('password'),
        'user_type' => 'Stakeholder',
       ]);
       User::create([
        'name' => 'Superadmin',
        'email' => 'superadmin@gmail.com',
        'password' => bcrypt('password'),
        'user_type' => 'Superadmin',
       ]);
       User::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('password'),
        'user_type' => 'Admin',
       ]);


    }
}
