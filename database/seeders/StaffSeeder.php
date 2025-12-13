<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run()
    {
        $staffMembers = [
            [
                'Fname' => 'Ginwin',
                'Lname' => 'Quicay',
                'address' => 'Nabua',
                'contact_no' => '09104175760',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('1234567'),
            ],
            [
                'Fname' => 'Maria',
                'Lname' => 'Dela Cruz',
                'address' => 'Legazpi',
                'contact_no' => '09123456789',
                'email' => 'mariastaff@gmail.com',
                'password' => Hash::make('1234567'),
            ],
            [
                'Fname' => 'John',
                'Lname' => 'Doe',
                'address' => 'Tabaco',
                'contact_no' => '09234567890',
                'email' => 'johnstaff@gmail.com',
                'password' => Hash::make('1234567'),
            ],
        ];

        DB::table('support_staff')->insert($staffMembers);
    }
}
