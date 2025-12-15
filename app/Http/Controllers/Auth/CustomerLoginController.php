<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerLoginController extends Controller
{
    public function showLoginForm() {
        return view('customer.customerlogin');
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->intended('/customer/dashboard');
        }

        return back()->with(['error' => 'Invalid email or password.']);
    }
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        return redirect('/home');
    }

}
