<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // Shows the admin login view
    public function showLoginForm() {
        return view('admin.adminlogin');
    }

    // Authenticates the admin using the admin guard and redirects on success
    public function login(Request $request) {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('admin/dashboard');
        }

        return back()->with(['error' => 'Invalid username or password.']);
    }

    // Logs out the authenticated admin, clears the session, and redirects to home
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home');
    }
}
