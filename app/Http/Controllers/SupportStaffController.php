<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SubmissionComment;
use App\Models\SupportStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SupportStaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:staff');
    }

    // Dashboard: list assigned submissions (and optionally unassigned ones)
    public function dashboard(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        // Allow filter by status, category, priority, date range
        $query = Submission::query()
            ->with(['comments', 'category', 'priority', 'staff'])
            ->where('is_deleted', false)
            ->where(function($q) use ($staff) {
                $q->where('StaffID', $staff->StaffID)
                  ->orWhereNull('StaffID'); // show unassigned so staff can pick up
            });

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('dateSubmitted', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('dateSubmitted', '<=', $request->to);
        }

        $submissions = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('staff.dashboard', compact('submissions'));
    }

    // Show a single submission and its comments
    public function show($id)
{
    $submission = Submission::with(['comments.staff', 'category', 'priority'])
        ->findOrFail($id);

    if ($submission->is_deleted || $submission->status === 'Closed') {
        abort(404);
    }

    return view('staff.submission_view', compact('submission'));
}


    // Assign submission to logged-in staff
    public function assignToMe($id)
    {
        $staff = Auth::guard('staff')->user();
        $submission = Submission::findOrFail($id);
        if ($submission->is_deleted) {
            return back()->with('error', 'Submission is deleted.');
        }

        $submission->StaffID = $staff->StaffID;
        $submission->save();

        return back()->with('success', 'Submission assigned to you.');
    }

    // Update status (e.g., Pending -> In Progress -> Resolved -> Closed)
    public function updateStatus(Request $request, $id)
{
    $submission = Submission::findOrFail($id);

    $flow = [
        'Pending' => 'In Progress',
        'In Progress' => 'Resolved',
        'Resolved' => 'Closed',
    ];

    $current = $submission->status;
    $nextAllowed = $flow[$current] ?? null;

    if ($request->status !== $current && $request->status !== $nextAllowed) {
        return back()->with('error', 'You must follow the required workflow order.');
    }

    // ✅ SET resolved_at ONLY ON FIRST RESOLVE
    if ($request->status === 'Resolved' && is_null($submission->resolved_at)) {
        $submission->resolved_at = now();
    }

    $submission->status = $request->status;
    $submission->save();

    return back()->with('success', 'Status updated successfully.');
}

public function close($id)
{
    $submission = Submission::findOrFail($id);

    if ($submission->status !== 'Resolved') {
        return back()->with('error', 'Only resolved submissions can be closed.');
    }

    $submission->status = 'Closed';
    $submission->save();

    return redirect()
        ->route('staff.dashboard')
        ->with('success', 'Submission closed successfully.');
}

    // Add comment only
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:2000',
            'action_taken' => 'nullable|string|max:1000',
        ]);

        $staff = Auth::guard('staff')->user();
        $submission = Submission::findOrFail($id);

        if ($submission->is_deleted) {
            return back()->with('error', 'Cannot comment on deleted submission.');
        }

        SubmissionComment::create([
            'SubmissionID' => $submission->SubmissionID,
            'StaffID' => $staff->StaffID,
            'comment' => $request->comment,
            'action_taken' => $request->action_taken,
        ]);

        // auto-assign to staff if not assigned
        if (!$submission->StaffID) {
            $submission->StaffID = $staff->StaffID;
            $submission->save();
        }

        return back()->with('success', 'Comment added.');
    }

    // Soft-delete (mark as invalid/duplicate) or permanent delete
    public function delete($id)
    {
        $staff = Auth::guard('staff')->user();
        $submission = Submission::findOrFail($id);

        // soft mark deleted
        $submission->is_deleted = true;
        $submission->status = 'Deleted';
        $submission->save();

        return redirect()->route('staff.dashboard')->with('success', 'Submission marked as deleted.');
    }

    // Permanently remove (dangerous) — optional admin-only
    public function forceDelete($id)
    {
        // You may add additional authorization check to restrict this action
        $submission = Submission::findOrFail($id);
        $submission->comments()->delete();
        $submission->delete();

        return redirect()->route('staff.dashboard')->with('success', 'Submission permanently deleted.');
    }

    // REPORTS
    // 1) feedback trends: count per category or per day in a date range
    // 2) average resolution time
    // 3) unresolved cases

    public function reports(Request $request)
    {
        // default last 30 days
        $from = $request->input('from', now()->subDays(30)->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));

        // Feedback trends by category
        $feedbackTrends = DB::table('submission')
            ->select('CategoryID', DB::raw('count(*) as total'))
            ->whereBetween(DB::raw('date(dateSubmitted)'), [$from, $to])
            ->where('is_deleted', false)
            ->groupBy('CategoryID')
            ->get();

        // Average resolution time (in hours)
        $avgResolution = DB::table('submission')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(SECOND, dateSubmitted, resolved_at)) / 3600 AS avg_hours'))
            ->whereNotNull('resolved_at')
            ->whereIn('status', ['Resolved', 'Closed'])
            ->whereBetween(DB::raw('DATE(resolved_at)'), [$from, $to])
            ->where('is_deleted', false)
            ->first();


        $avgHours = $avgResolution->avg_hours ?? null;

        // Unresolved cases
        $unresolved = Submission::where('is_deleted', false)
            ->whereNotIn('status', ['Resolved', 'Closed'])
            ->whereBetween(DB::raw('date(dateSubmitted)'), [$from, $to])
            ->orderBy('dateSubmitted', 'desc')
            ->get();

        // For convenience, we can prepare basic counts
        $totalSubmitted = Submission::where('is_deleted', false)
            ->whereBetween(DB::raw('date(dateSubmitted)'), [$from, $to])
            ->count();

        $totalResolved = Submission::whereNotNull('resolved_at')
            ->whereBetween(DB::raw('DATE(resolved_at)'), [$from, $to])
            ->where('is_deleted', false)
            ->count();


        return view('staff.reports', compact(
            'feedbackTrends', 'avgHours', 'unresolved', 'from', 'to', 'totalSubmitted', 'totalResolved'
        ));
    }

    // CSV export for unresolved cases or summary
    public function exportReportCsv(Request $request)
{
    $from = $request->input('from', now()->subDays(30)->format('Y-m-d'));
    $to = $request->input('to', now()->format('Y-m-d'));

    // 1) Unresolved submissions
    $unresolved = Submission::with(['customer', 'category', 'priority', 'staff'])
        ->where('is_deleted', false)
        ->whereNotIn('status', ['Resolved', 'Closed'])
        ->whereBetween(DB::raw('DATE(dateSubmitted)'), [$from, $to])
        ->orderBy('dateSubmitted', 'desc')
        ->get();

    // 2) Feedback trends by category
    $feedbackTrends = Submission::with('category')
        ->select('CategoryID', DB::raw('count(*) as total'))
        ->whereBetween(DB::raw('DATE(dateSubmitted)'), [$from, $to])
        ->where('is_deleted', false)
        ->groupBy('CategoryID')
        ->get();

    // 3) Average resolution time per category (in hours)
    $resolutionTimes = Submission::with('category')
        ->select('CategoryID', DB::raw('AVG(TIMESTAMPDIFF(SECOND, dateSubmitted, resolved_at)) / 3600 AS avg_hours'))
        ->whereNotNull('resolved_at')
        ->whereIn('status', ['Resolved', 'Closed'])
        ->whereBetween(DB::raw('DATE(resolved_at)'), [$from, $to])
        ->where('is_deleted', false)
        ->groupBy('CategoryID')
        ->get();

    $callback = function () use ($unresolved, $feedbackTrends, $resolutionTimes) {
        $handle = fopen('php://output', 'w');

        // Unresolved submissions
        fputcsv($handle, ['Unresolved Submissions']);
        fputcsv($handle, ['SubmissionID','Customer Name','Category','Priority','Staff','Status','Date Submitted','Description']);
        foreach ($unresolved as $sub) {
            fputcsv($handle, [
                $sub->SubmissionID,
                $sub->customer?->Fname . ' ' . $sub->customer?->Lname ?? 'N/A',
                $sub->category?->categoryname ?? 'N/A',
                $sub->priority?->priorityname ?? 'N/A',
                $sub->staff?->Fname . ' ' . $sub->staff?->Lname ?? 'Unassigned',
                $sub->status,
                $sub->dateSubmitted,
                str_replace(["\r","\n"], ['',' '], $sub->description),
            ]);
        }

        // Feedback trends
        fputcsv($handle, []); // empty row
        fputcsv($handle, ['Feedback Trends']);
        fputcsv($handle, ['Category','Total Submissions']);
        foreach ($feedbackTrends as $trend) {
            fputcsv($handle, [
                $trend->category?->categoryname ?? 'N/A',
                $trend->total,
            ]);
        }

        // Resolution times
        fputcsv($handle, []); // empty row
        fputcsv($handle, ['Average Resolution Time (Hours) Per Category']);
        fputcsv($handle, ['Category','Avg Resolution Time (Hours)']);
        foreach ($resolutionTimes as $res) {
            fputcsv($handle, [
                $res->category?->categoryname ?? 'N/A',
                round($res->avg_hours, 2),
            ]);
        }

        fclose($handle);
    };

    $filename = 'submission_report_'.now()->format('Ymd_His').'.csv';

    return response()->streamDownload($callback, $filename, [
        'Content-Type' => 'text/csv',
    ]);
}
}
