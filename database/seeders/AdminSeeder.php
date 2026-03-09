<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            User::updateOrCreate(
                ['email' => 'amrramadan22004@vetly.com'], 
                [
                    'name' => 'Amr Eloraby',
                    'phone' => '01097896081',
                    'password' => Hash::make('123456789A'),
                    'is_admin' => true,
                ]
            );
        }
    }
}
