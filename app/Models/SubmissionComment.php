<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionComment extends Model
{
    protected $table = 'submission_comments';
    protected $fillable = [
        'SubmissionID', 
        'StaffID', 
        'comment', 
        'action_taken'
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class, 'SubmissionID', 'SubmissionID');
    }

    public function staff()
    {
        return $this->belongsTo(SupportStaff::class, 'StaffID', 'StaffID');
    }
}
