<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizerInfoSeeder extends Seeder
{
    public function run()
    {
        $organizers = DB::table('users')->where('role', 'organizer')->get();

        foreach ($organizers as $organizer) {
            DB::table('organizers_infos')->insert([
                'user_id' => $organizer->user_id,
                'bank_account_name' => $organizer->name,
                'bank_account_number' => rand(10000000, 99999999),
                'bank_code' => 'BCA',
                'is_verified' => true,
                'disbursement_ready' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
