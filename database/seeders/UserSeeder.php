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
            DB::beginTransaction();
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'johndoe@example.com',
                'password' => Hash::make('12345678'), // Bcrypt hashing
            ]);

            Account::create([
                'user_id' => $user->id,  // Menggunakan ID user yang baru dibuat
                'name' => $user->name,
                'role' => 'admin',
                'division_id' => 1   // Sesuaikan dengan kebutuhan
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
        }
    }
}
