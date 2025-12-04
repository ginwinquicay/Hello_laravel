<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'customer';
    protected $primaryKey = 'CustomerID'; 
    public $timestamps = true; 
    protected $fillable = [
        'Fname',
        'Lname',
        'address',
        'contact_no',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
    ];
}
