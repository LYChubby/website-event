<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->count() === 0) {
            $users = User::factory()->count(5)->create(['role' => 'user']);
        }

        foreach ($users as $user) {
            Notification::factory()->count(3)->create([
                'user_id' => $user->user_id,
                'type' => 'system',
                'is_read' => false,
            ]);
        }

        $this->command->info('Dummy notifications seeded for users.');
    }
}
