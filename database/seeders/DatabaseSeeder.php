<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::updateOrCreate(
            [
                'email' => 'admin@mail.com',
            ],
            [
                ...\App\Models\User::factory()->makeOne([
                    'name' => 'Admin',
                    'email' => 'admin@mail.com',
                ])->toArray(),
                'password' => \Hash::make('power@123'),
            ]
        );
    }
}
