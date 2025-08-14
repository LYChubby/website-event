<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'status' => 'Aktif',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'google_id' => null,
            ],
            [
                'name' => 'Disney',
                'email' => 'disney@example.com',
                'role' => 'organizer',
                'status' => 'Aktif',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'google_id' => null,
            ],
            [
                'name' => 'Event Organizer2',
                'email' => 'organizer2@example.com',
                'role' => 'organizer',
                'status' => 'Aktif',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'google_id' => null,
            ],
            [
                'name' => 'Event Organizer3',
                'email' => 'organizer3@example.com',
                'role' => 'organizer',
                'status' => 'Aktif',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'google_id' => null,
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'role' => 'user',
                'status' => 'Aktif',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'google_id' => null,
            ]
        ]);

        // Generate 10 more random users
        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'role' => 'user',
                'status' => 'Aktif',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'google_id' => null,
            ]);
        }
    }
}
