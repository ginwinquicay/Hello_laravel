<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SystemAdmin extends Authenticatable
{
    use Notifiable;

    protected $table = 'system_admin';
    protected $primaryKey = 'AdminID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Fname', 
        'Lname', 
        'username', 
        'email', 
        'password', 
        'contact_no', 
        'position'
    ];

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'AdminID';
    }
}
