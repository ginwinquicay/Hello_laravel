<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffLoginController extends Controller
{
    // Shows the staff login view
    public function showLoginForm() {
        return view('staff.stafflogin');
    }

    // Authenticates the staff using the staff guard and redirects on success
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('staff')->attempt($credentials)) {
            return redirect('/staff/dashboard');
        }

        return back()->with(['error' => 'Invalid email or password.']);
    }

    // Logs out the authenticated staff, clears the session, and redirects to staff login
    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login-staff');
    }
}
