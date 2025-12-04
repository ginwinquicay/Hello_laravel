<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test() {
        return view('test');
    }

    public function getInput(Request $request) {
        $user_input = $request->input('user_input');

        $data =  [
            'user_input' => $user_input,
        ];
        return view('user_input', $data);
    }
}
