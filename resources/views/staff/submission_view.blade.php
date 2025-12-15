<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Submission</title>

<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- GOOGLE FONTS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Display&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

<style>
:root {
  --main-bg: #e2e2e2;
  --nav-bg: #4A70A9;
  --textprimary-color:#4A70A9;
  --primary-color: #4cb06c;
  --secondary-color: #6494da;
  --hover-accent: #25783e;
  --hover-accent2: #486591;
  --radius: 0.75rem;
  --brand-font: "Momo Trust Display", sans-serif;
  --text-color: #6494da;
  --danger-color: red;
}

/* GLOBAL */
body {
  background-color: var(--main-bg);
  font-family: 'Poppins', Arial, sans-serif;
  margin: 0;
}

/* NAVBAR */
.navbar {
  background-color: var(--nav-bg);
}
.navbar-brand {
  color: white !important;
  font-weight: 500;
  font-family: var(--brand-font);
}
/* CARD */
.card-custom {
  background: white;
  border-radius: var(--radius);
  border: none;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.text-primary {
  color: var(--primary-color) !important;
  font-weight: 600;
}
.text{
  color: var(--text-color);
}
/* BUTTONS */
.btn-dashboard {
  background-color: var(--primary-color);
  color: white;
  border-radius: 8px;
  padding: 10px 20px;
  font-weight: 500;
  transition: all 0.3s ease;
}
.btn-dashboard:hover {
  background-color: var(--hover-accent);
  transform: scale(0.98);
  color: white;
}

.btn-dashboards {
  background-color: var(--secondary-color);
  color: white;
  border-radius: 8px;
  padding: 10px 20px;
  font-weight: 500;
  transition: all 0.3s ease;
}
.btn-dashboards:hover {
  background-color: var(--hover-accent2);
  transform: scale(0.98);
  color: white;
}

/* BADGES */
.badge-orange {
  background-color: #fd7e14 !important;
  color: white;
}

/* FORMS */
.form-control {
  border-radius: 8px;
}
.clsbtn{
  background-color: var(--danger-color);
  color: white;
  border-radius: 6px;
  transition: all 0.3s ease;
}
.clsbtn:hover{
  background-color: #860f0f;
  transform: scale(0.98);
}
.btn-danger{
  transition: all 0.3s ease;
  padding: 5px 10px;
}
.btn-danger:hover{
  transform: scale(0.98);
}
.delbtn{
  float: right;
  margin-top: 15px;
  background-color: var(--danger-color);
  color: white;
  border-radius: 6px;
  padding: 5px 15px;
  transition: all 0.3s ease;
}
.delbtn:hover{
  transform: scale(0.98);
  background-color: #860f0f;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg py-3 px-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ECHOCARE STAFF PORTAL</a>
  </div>
</nav>

<div class="container py-4">

  <div class="card card-custom p-4 mb-4">
    <h2 class="text mb-3">Submission Details</h2>

    <div class="mb-3"><strong>ID:</strong> {{ $submission->SubmissionID }}</div>
    <div class="mb-3"><strong>Customer:</strong> {{ $submission->customer->Fname ?? 'N/A' }} {{ $submission->customer->Lname ?? '' }}</div>
    <div class="mb-3"><strong>Category:</strong> {{ $submission->category->categoryname ?? 'N/A' }}</div>

    <div class="mb-3">
      <strong>Priority:</strong>
      <span class="badge 
        @if($submission->priority->priorityname == 'Critical') bg-danger
        @elseif($submission->priority->priorityname == 'High') badge-orange
        @elseif($submission->priority->priorityname == 'Medium') bg-warning
        @elseif($submission->priority->priorityname == 'Low') bg-success
        @else bg-secondary @endif">
        {{ $submission->priority->priorityname ?? 'N/A' }}
      </span>
    </div>

    <div class="mb-3 d-flex align-items-center gap-2">
  <strong class="me-2">Status:</strong>

  <!-- Status form -->
  <form action="{{ route('staff.submission.status', $submission->SubmissionID) }}" method="POST" class="d-inline-block">
    @csrf
    <select name="status" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
      <option value="Pending" @selected($submission->status == 'Pending')>Pending</option>
      <option value="In Progress" @selected($submission->status == 'In Progress') @disabled($submission->status != 'Pending')>In Progress</option>
      <option value="Resolved" @selected($submission->status == 'Resolved') @disabled($submission->status != 'In Progress')>Resolved</option>
    </select>
  </form>

  <!-- Close button form -->
  @if($submission->status === 'Resolved')
    <form action="{{ route('staff.submission.close', $submission->SubmissionID) }}" method="POST" class="d-inline-block">
      @csrf
      <button type="submit" class="clsbtn btn-danger" onclick="return confirm('Are you sure you want to close this submission?')">
        Close
      </button>
    </form>
  @endif
</div>


    <div class="mb-3"><strong>Description:</strong> {{ $submission->description }}</div>
    <div class="mb-3"><strong>Date Submitted:</strong> {{ \Carbon\Carbon::parse($submission->dateSubmitted)->format('M d, Y') }}</div>

    <!-- COMMENTS SECTION -->
    <div class="card card-custom p-4 mt-4">
  <h4 class="text mb-3">Comments</h4>

  <div class="mb-3">
    @forelse($submission->comments as $comment)
      <div class="border rounded p-2 mb-2">
        <strong>{{ $comment->staff?->Fname ?? 'Staff' }}:</strong>
        <span>{{ $comment->comment }}</span>
        @if($comment->action_taken)
          <div><em>Action taken: {{ $comment->action_taken }}</em></div>
        @endif
        <small class="text-muted">{{ $comment->created_at->format('M d, Y H:i') }}</small>
      </div>
    @empty
      <div class="text-muted">No comments yet.</div>
    @endforelse
  </div>

  <form action="{{ route('staff.submission.comment', $submission->SubmissionID) }}" method="POST">
    @csrf
    <div class="mb-3">
      <textarea name="comment" class="form-control" placeholder="Write your comment here..." rows="3" required></textarea>
    </div>
    <div class="mb-3">
      <input type="text" name="action_taken" class="form-control" placeholder="Optional action taken">
    </div>

    <div class="d-flex justify-content-between">
      <!-- Left side: Return & Add Comment -->
      <div class="d-flex gap-2">
        <a href="{{ route('staff.dashboard') }}" class="btn btn-dashboards">Return</a>
        <button type="submit" class="btn btn-dashboard">Add Comment</button>
      </div>
    </div>
  </form>
</div>
@if(!$submission->is_deleted)
        <form action="{{ route('staff.submission.delete', $submission->SubmissionID) }}" method="POST" onsubmit="return confirm('Are you sure you want to mark this submission as deleted?');" class="d-inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="delbtn">Delete</button>
        </form>
      @else
        <span class="text-muted align-self-center">Deleted. Admin can permanently remove.</span>
      @endif
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
