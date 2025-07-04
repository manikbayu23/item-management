<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            User::create([
                'name' => 'Admin Inventory',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'phone_number' => '0813387563323',
                'password' => Hash::make('12345678'), // Bcrypt hashing
                'role' => 'admin',
                'division_id' => 1,
                'position_id' => 1,
                'created_by' => 'admin',
                'updated_by' => 'admin'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
