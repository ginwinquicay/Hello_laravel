<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SystemAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'Fname'      => 'John',
                'Lname'      => 'Doe',
                'username'   => 'admin1',
                'password'   => Hash::make('password123'),
                'email'      => 'admin1@example.com',
                'contact_no' => '09123456789',
                'position'   => 'Super Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Fname'      => 'Jane',
                'Lname'      => 'Smith',
                'username'   => 'admin2',
                'password'   => Hash::make('password123'),
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
