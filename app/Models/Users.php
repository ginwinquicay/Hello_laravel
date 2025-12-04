<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    public function getAllUsers() {
        $query = DB::select('Select * from users');
        return $query;
    }
}
