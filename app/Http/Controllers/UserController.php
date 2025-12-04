<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

class UserController extends Controller
{
    public function index() {
        $users = new Users();
        $result = $users->getAllUsers();
        $data = [
            'users'=> $result
        ];
        return view('users', $data);
    }
}
