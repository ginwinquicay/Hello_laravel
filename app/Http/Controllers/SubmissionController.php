<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SupportStaff;
use App\Models\Category;
use App\Models\PriorityLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\SubmissionAssignmentService; // ⬅ ADD THIS

class SubmissionController extends Controller
{
    public function create()
    {
        $categories = \DB::table('category')->get();
        $priorities = \DB::table('priority_level')->get();

        return view('customer.submission', compact('categories', 'priorities'));
    }

    public function store(Request $request)
{
// Validate input
$request->validate([
'category' => 'required|exists:category,CategoryID',
'description' => 'required|string|max:2000',
'priority' => 'nullable|exists:priority_level,PriorityID',
]);

// Find staff with the least number of pending submissions
$staffWithLeastPending = \DB::table('support_staff')
    ->leftJoin('submission', function($join) {
        $join->on('support_staff.StaffID', '=', 'submission.StaffID')
             ->where('submission.status', 'Pending')
             ->where('submission.is_deleted', false);
    })
    ->select('support_staff.StaffID', 'support_staff.Fname', 'support_staff.Lname')
    ->groupBy('support_staff.StaffID', 'support_staff.Fname', 'support_staff.Lname')
    ->orderByRaw('COUNT(submission.SubmissionID) ASC')
    ->first();

$assignedStaffID = $staffWithLeastPending?->StaffID ?? null; // This should be the actual staff ID

// Create new submission
$submission = Submission::create([
    'CustomerID' => auth()->guard('customer')->id(),
    'CategoryID' => $request->category,
    'PriorityID' => $request->priority ?? 1,
    'description' => $request->description,
    'status' => 'Pending',
    'dateSubmitted' => now(),
    'StaffID' => $assignedStaffID, // <- assign actual StaffID
]);


return redirect()->route('customer.dashboard')
                 ->with('success', 'Your feedback has been submitted successfully!');

}
    public function destroy($id)
    {
        $submission = Submission::findOrFail($id);
        $submission->delete();

        return redirect()->route('customer.dashboard')->with('success', 'Submission deleted successfully!');
    }

    public function edit($id)
    {
        $submission = Submission::findOrFail($id);
        $categories = Category::all();
        $priorities = PriorityLevel::all();
        return view('customer.editsubmission', compact('submission', 'categories', 'priorities'));
    }

    public function update(Request $request, $id)
    {
        $submission = Submission::findOrFail($id);
        $submission->update([
            'description' => $request->description,
            'CategoryID' => $request->CategoryID,
            'PriorityID' => $request->PriorityID,
        ]);

        return redirect()->route('customer.dashboard')->with('success', 'Submission updated successfully!');
    }

    public function customerDashboard()
    {
        $customer = Auth::guard('customer')->user();

        $submissions = DB::table('submission')
    ->leftJoin('category', 'submission.CategoryID', '=', 'category.CategoryID')
    ->leftJoin('priority_level', 'submission.PriorityID', '=', 'priority_level.PriorityID')
    ->leftJoin('support_staff', 'submission.StaffID', '=', 'support_staff.StaffID')
    ->select(
        'submission.*',
        'category.categoryname',
        'priority_level.priorityname',
        DB::raw("CONCAT(support_staff.Fname, ' ', support_staff.Lname) AS staff_name")
    )
    ->where('submission.CustomerID', auth()->guard('customer')->id())
    ->orderBy('submission.created_at', 'DESC')
    ->get();

        $submissions = Submission::with(['category', 'priority', 'comments.staff'])
        ->where('CustomerID', auth()->guard('customer')->id())
        ->orderBy('created_at', 'DESC')
        ->get();

        return view('customer.dashboard', compact('submissions'));
    }
}
