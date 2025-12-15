<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerLoginController extends Controller
{
    // Shows the customer login view
    public function showLoginForm() {
        return view('customer.customerlogin');
    }

    // Authenticates the customer using the customer guard and redirects on success
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->intended('/customer/dashboard');
        }

        return back()->with(['error' => 'Invalid email or password.']);
    }

    // Logs out the authenticated customer, clears the session, and redirects to home
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home');
    }
}
