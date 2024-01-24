<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Actor::factory(3)->create();
        \App\Models\Player::factory(10)->create();

        \App\Models\User::factory()->create([
            'username' => 'username',
            'password' => Hash::make('11111111'),
            'created_date' => now(),
        ]);
    }
}
