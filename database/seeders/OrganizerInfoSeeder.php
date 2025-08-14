<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizerInfoSeeder extends Seeder
{
    public function run()
    {
        // Get all organizer users except user_id = 2
        $organizers = DB::table('users')
            ->where('role', 'organizer')
            ->get();

        foreach ($organizers as $organizer) {
            DB::table('organizers_infos')->insert([
                'user_id' => $organizer->user_id,
                'bank_account_name' => $organizer->name . ' Inc.',
                'bank_account_number' => mt_rand(1000000000, 9999999999), // Random 10-digit number
                'bank_code' => $this->getRandomBankCode(),
                'is_verified' => true,
                'disbursement_ready' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Get random Indonesian bank code
     */
    protected function getRandomBankCode()
    {
        $banks = [
            'BCA',
            'BRI',
            'BNI',
            'Mandiri',
            'CIMB',
            'Permata',
            'Maybank',
            'Panin',
            'Danamon'
        ];

        return $banks[array_rand($banks)];
    }
}
