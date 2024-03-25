<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Message;
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
        User::factory()->create([
            'name' => 'Jeric June Logan',
            'email' => 'loganjeric25@gmail.com',
            'password' => bcrypt('password'),
        ]);

        User::factory(10)->create();
        Chat::factory(20)->create();
        Message::factory(50)->create();
    }
}
