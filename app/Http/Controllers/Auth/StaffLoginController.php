<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffLoginController extends Controller
{
   public function showLoginForm() {
    return view('staff.stafflogin'); // matches your route + blade
}

public function login(Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::guard('staff')->attempt($credentials)) {
        return redirect('/staff/dashboard'); // matches your route
    }

    return back()->with(['error' => 'Invalid email or password.']);
}

public function logout(Request $request)
{
    Auth::guard('staff')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login-staff'); // redirect back to your login page
}

}
