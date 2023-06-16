<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@mail.com',
        ], [
            'id' => '996b2511-6e07-42a2-b112-bddaaa7229fe',
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => \Hash::make('power@123'),
            'remember_token' => Str::random(10),
        ]);

        User::factory(20)->create();
        User::factory(20)->unverified()->create();
    }
}
