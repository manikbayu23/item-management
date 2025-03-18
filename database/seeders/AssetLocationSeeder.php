<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            [
                'code' => '51.03.05.2002',
                'province' => 'Bali',
                'regency' => 'Badung',
                'district' => 'Kuta Selatan',
                'status' => '2',
                'area' => 'Desa Ungasan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
