<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class PriorityLevel extends Authenticatable
{
    use Notifiable;

    protected $table = 'priority_level';
    protected $primaryKey = 'PriorityID';
    public $timestamps = true;
    protected $fillable = [
        'priorityname',
        'responsetime',
        'description',
];
}
