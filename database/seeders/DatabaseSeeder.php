<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 1 admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin', // Pastikan ada kolom role di tabel users
            'password' => Hash::make('admin123'), // Ganti password sesuai kebutuhan
        ]);

        

        $this->call(NotificationSeeder::class);
    }
}
