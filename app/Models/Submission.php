<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'submission';
    protected $primaryKey = 'SubmissionID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'CustomerID', 
        'CategoryID', 
        'PriorityID', 
        'StaffID',
        'description', 
        'dateSubmitted', 
        'status', 
        'resolved_at', 
        'is_deleted'
    ];

    protected $casts = [
        'dateSubmitted' => 'datetime',
        'resolved_at' => 'datetime',
        'is_deleted' => 'boolean',
    ];

    // relations
    public function staff()
    {
        return $this->belongsTo(SupportStaff::class, 'StaffID', 'StaffID');
    }
    // optional category/priority relations if you have such models
    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID', 'CategoryID');
    }

    public function priority()
    {
        return $this->belongsTo(PriorityLevel::class, 'PriorityID', 'PriorityID');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'CustomerID');
    }

    public function comments()
    {
        return $this->hasMany(SubmissionComment::class, 'SubmissionID', 'SubmissionID');
    }



}


