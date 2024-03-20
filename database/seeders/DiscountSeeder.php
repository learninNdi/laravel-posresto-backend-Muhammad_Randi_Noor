<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Discount::create([
            'name' => 'Welcome Ramadhan',
            'description' => 'Diskon bulan Ramadhan 1445H',
            'type' => 'percentage',
            'value' => 15,
            'status' => 'active',
            'expired_date' => '2024-04-08',
        ]);

        \App\Models\Discount::create([
            'name' => 'Welcome Hari Raya',
            'description' => 'Diskon hari raya 1445H',
            'type' => 'percentage',
            'value' => 20,
            'status' => 'active',
            'expired_date' => '2024-04-12',
        ]);

        \App\Models\Discount::create([
            'name' => 'Welcome Qurban',
            'description' => 'Diskon Qurban 1445H',
            'type' => 'percentage',
            'value' => 10,
            'status' => 'active',
            'expired_date' => '2024-06-15',
        ]);
    }
}
