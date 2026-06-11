<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'albert@gmail.com'],
            [
                'name' => 'Albert',
                'password' => \Illuminate\Support\Facades\Hash::make('yaya12,.'),
                'birthdate' => '2000-01-01',
                'is_admin' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User Wibu',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'birthdate' => '2002-05-15',
                'is_admin' => false,
            ]
        );

        $this->call(AnimeSeeder::class);
    }
}
