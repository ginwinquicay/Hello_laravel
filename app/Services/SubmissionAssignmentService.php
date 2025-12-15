<?php

namespace App\Services;

use App\Models\SupportStaff;
use App\Models\Submission;

class SubmissionAssignmentService
{
    public static function assignStaff()
    {

        $freeStaff = SupportStaff::whereDoesntHave('submissions', function ($q) {
            $q->where('status', 'Pending')->where('is_deleted', false);
        })->get();

        if ($freeStaff->count()) {
            return $freeStaff->random()->StaffID;
        }

        return SupportStaff::inRandomOrder()->first()->StaffID;
    }
}
