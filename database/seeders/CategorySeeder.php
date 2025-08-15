<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Music Concert',
                'slug' => Str::slug('Music Concert'),
                'is_active' => true
            ],
            [
                'name' => 'Sports',
                'slug' => Str::slug('Sports'),
                'is_active' => true
            ],
            [
                'name' => 'Art Exhibition',
                'slug' => Str::slug('Art Exhibition'),
                'is_active' => true
            ],
            [
                'name' => 'Conference',
                'slug' => Str::slug('Conference'),
                'is_active' => true
            ],
            [
                'name' => 'Workshop',
                'slug' => Str::slug('Workshop'),
                'is_active' => true
            ],
            [
                'name' => 'Festival',
                'slug' => Str::slug('Festival'),
                'is_active' => true
            ],
            [
                'name' => 'Charity',
                'slug' => Str::slug('Charity'),
                'is_active' => true
            ],
            [
                'name' => 'Food & Drink',
                'slug' => Str::slug('Food & Drink'),
                'is_active' => true
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
