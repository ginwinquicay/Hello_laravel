<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'Fname'      => 'Test Admin',
                'Lname'      => 'Ginwin',
                'username'   => 'admin1',
                'password'   => Hash::make('12345678'),
                'email'      => 'admin1@example.com',
                'contact_no' => '09123456789',
                'position'   => 'Super Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Fname'      => 'Admin 2',
                'Lname'      => 'Smith',
                'username'   => 'admin2',
                'password'   => Hash::make('12345678'),
                'email'      => 'admin2@example.com',
                'contact_no' => '09987654321',
                'position'   => 'System Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('system_admin')->insert($admins);
    }
}
