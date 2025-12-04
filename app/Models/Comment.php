<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'SubmissionID',
        'staff_id',
        'message',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class, 'SubmissionID');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id'); // adjust if needed
    }
}
