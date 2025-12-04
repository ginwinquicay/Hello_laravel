<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomerRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('customer.customerregister');
    }

    public function register(Request $request)
    {
        $request->validate([
            'Fname' => 'required|string|max:255',
            'Lname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_no' => 'required|string|max:20',
            'email' => 'required|email|unique:customer,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $customer = new customer();
        $customer->Fname = $request->Fname;
        $customer->Lname = $request->Lname;
        $customer->address = $request->address;
        $customer->contact_no = $request->contact_no;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password);
        $customer->save();

        return redirect('/login-customer')->with('success', 'Welcome new User! Please log in.');
    }
}
