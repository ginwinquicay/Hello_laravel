<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class SupportStaff extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'support_staff';
    protected $primaryKey = 'StaffID';
    public $timestamps = true;
    protected $fillable = [
        'Fname',
        'Lname',
        'address',
        'contact_no',
        'email',
        'password',
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'StaffID', 'StaffID');
    }
}
