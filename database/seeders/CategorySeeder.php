<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category')->insert([
            [
                'CategoryID' => 1,
                'categoryname' => 'Service Complaint',
                'description' => 'Feedback regarding poor or unsatisfactory service.'
            ],
            [
                'CategoryID' => 2,
                'categoryname' => 'Product Issue',
                'description' => 'Complaints about defective or malfunctioning products.'
            ],
            [
                'CategoryID' => 3,
                'categoryname' => 'Billing Problem',
                'description' => 'Issues related to invoices, payments, or charges.'
            ],
            [
                'CategoryID' => 4,
                'categoryname' => 'Suggestion',
                'description' => 'Suggestions for improving services or products.'
            ],
            [
                'CategoryID' => 5,
                'categoryname' => 'Other',
                'description' => 'Any other feedback not categorized above.'
            ],
        ]);
    }
}
