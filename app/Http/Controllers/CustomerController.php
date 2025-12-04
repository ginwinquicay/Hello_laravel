<?php

namespace App\Http\Controllers;
use App\Models\Submission;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
public function dashboard()
{
    $submissions = Submission::with('comments.staff')
        ->where('customer_id', Auth::guard('customer')->id())
        ->get();

    return view('customer.dashboard', compact('submissions'));
}

}
