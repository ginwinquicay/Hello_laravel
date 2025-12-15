<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Category;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // Displays the customer dashboard with their submissions and related staff comments
    public function dashboard()
    {
        $submissions = Submission::with('comments.staff')
            ->where('customer_id', Auth::guard('customer')->id())
            ->get();

        return view('customer.dashboard', compact('submissions'));
    }

    // Shows the feedback form with available categories and priorities
    public function feedbackForm()
    {
        $categories = Category::all();
        $priorities = Priority::all();

        return view('customer.feedback', compact('categories', 'priorities'));
    }
}
