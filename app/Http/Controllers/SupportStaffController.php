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
        $staff = Auth::guard('staff')->user();
        $submission = Submission::with(['comments.staff', 'category', 'priority'])->findOrFail($id);

        // basic permission: ensure staff is assigned or allow viewing unassigned
        if ($submission->is_deleted) {
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
        $request->validate([
            'status' => 'required|string|max:50',
            'comment' => 'nullable|string|max:2000',
            'action_taken' => 'nullable|string|max:1000',
        ]);

        $staff = Auth::guard('staff')->user();
        $submission = Submission::findOrFail($id);

        if ($submission->is_deleted) {
            return back()->with('error', 'Cannot update deleted submission.');
        }

        $submission->status = $request->status;

        // if resolved, set resolved_at
        if (strtolower($request->status) === 'resolved' || strtolower($request->status) === 'closed') {
            $submission->resolved_at = now();
        }

        // if status moved from resolved back to something else, clear resolved_at (optional)
        if (!in_array(strtolower($request->status), ['resolved', 'closed'])) {
            $submission->resolved_at = null;
        }

        // assign staff if not assigned
        if (empty($submission->StaffID)) {
            $submission->StaffID = $staff->StaffID;
        }

        $submission->save();

        // Add comment
        if ($request->filled('comment') || $request->filled('action_taken')) {
            SubmissionComment::create([
                'SubmissionID' => $submission->SubmissionID,
                'StaffID' => $staff->StaffID,
                'comment' => $request->comment ?? '',
                'action_taken' => $request->action_taken ?? null,
            ]);
        }

        return back()->with('success', 'Status updated successfully.');
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
            ->select(DB::raw('avg(timestampdiff(SECOND, dateSubmitted, resolved_at))/3600 as avg_hours'))
            ->whereNotNull('resolved_at')
            ->whereBetween(DB::raw('date(resolved_at)'), [$from, $to])
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

        $totalResolved = Submission::where('is_deleted', false)
            ->whereNotNull('resolved_at')
            ->whereBetween(DB::raw('date(resolved_at)'), [$from, $to])
            ->count();

        return view('staff.reports', compact(
            'feedbackTrends', 'avgHours', 'unresolved', 'from', 'to', 'totalSubmitted', 'totalResolved'
        ));
    }

    // CSV export for unresolved cases or summary
    public function exportUnresolvedCsv(Request $request)
    {
        $from = $request->input('from', now()->subDays(30)->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));

        $rows = Submission::where('is_deleted', false)
            ->whereNotIn('status', ['Resolved', 'Closed'])
            ->whereBetween(DB::raw('date(dateSubmitted)'), [$from, $to])
            ->orderBy('dateSubmitted', 'desc')
            ->get();

        $callback = function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['SubmissionID','CustomerID','CategoryID','PriorityID','StaffID','Status','DateSubmitted','Description']);
            foreach ($rows as $r) {
                fputcsv($handle, [
                    $r->SubmissionID,
                    $r->CustomerID,
                    $r->CategoryID,
                    $r->PriorityID,
                    $r->StaffID,
                    $r->status,
                    $r->dateSubmitted,
                    str_replace(["\r","\n"], ['',' '], $r->description),
                ]);
            }
            fclose($handle);
        };

        $filename = 'unresolved_submissions_'.now()->format('Ymd_His').'.csv';

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
