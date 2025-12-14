<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Category;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $submissions = Submission::with('comments.staff')
            ->where('customer_id', Auth::guard('customer')->id())
            ->get();

        return view('customer.dashboard', compact('submissions'));
    }

    // Show feedback form
    public function feedbackForm()
    {
        $categories = Category::all();
        $priorities = Priority::all(); // each priority has a `responsetime` field

        return view('customer.feedback', compact('categories', 'priorities'));
    }
}
