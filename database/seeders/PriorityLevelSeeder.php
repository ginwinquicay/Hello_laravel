<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriorityLevelSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('priority_level')->insert([
            [
                'PriorityID' => 1,
                'priorityname' => 'Low',
                'responsetime' => '72 hours',
                'description' => 'Issues that are minor and do not require immediate attention.'
            ],
            [
                'PriorityID' => 2,
                'priorityname' => 'Medium',
                'responsetime' => '48 hours',
                'description' => 'Issues that need timely attention but are not urgent.'
            ],
            [
                'PriorityID' => 3,
                'priorityname' => 'High',
                'responsetime' => '24 hours',
                'description' => 'Important issues that require prompt response.'
            ],
            [
                'PriorityID' => 4,
                'priorityname' => 'Critical',
                'responsetime' => '4 hours',
                'description' => 'Urgent issues that require immediate action.'
            ],
        ]);
    }
}
