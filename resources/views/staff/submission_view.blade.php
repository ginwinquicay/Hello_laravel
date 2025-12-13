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
.navlink {
  color: white !important;
  font-weight: 500;
  font-family: var(--brand-font);
  text-decoration: none;
  padding: 7px 10px;
  border-radius: 6px;
}
.navlink:hover {
  background-color: red;
  opacity: 0.8;
  transform: scale(1.05);
}
.nav-btn {
  background-color: var(--primary-color);
  color: white;
  border-radius: 8px;
  padding: 10px 20px;
  font-weight: 500;
  text-decoration: none;
}
.nav-btn:hover {
  background-color: var(--hover-accent);
  transform: scale(1.05);
  color: white;
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
  transform: scale(1.04);
  color: white;
}

.btn-dashboards {
  background-color: var(--secondary-color);
  color: white;
  border-radius: 8px;
  padding: 10px 20px;
  font-weight: 500;transition: all 0.3s ease;
}
.btn-dashboards:hover {
  background-color: var(--hover-accent2);
  transform: scale(1.04);
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
    <h2 class="text-dark mb-3">Submission Details</h2>

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

    <div class="mb-3">
      <strong>Status:</strong>
      <form action="{{ route('staff.submission.status', $submission->SubmissionID) }}" method="POST">
        @csrf
        <select name="status" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
          <option value="Pending" @if($submission->status == 'Pending') selected @endif>Pending</option>
          <option value="In Progress" @if($submission->status == 'In Progress') selected @endif>In Progress</option>
          <option value="Resolved" @if($submission->status == 'Resolved') selected @endif>Resolved</option>
          <option value="Closed" @if($submission->status == 'Closed') selected @endif>Closed</option>
        </select>
      </form>
    </div>

    <div class="mb-3"><strong>Description:</strong> {{ $submission->description }}</div>
    <div class="mb-3"><strong>Date Submitted:</strong> {{ \Carbon\Carbon::parse($submission->dateSubmitted)->format('M d, Y') }}</div>

    <!-- COMMENTS SECTION -->
    <div class="card card-custom p-4 mt-4">
      <h4 class="text-dark mb-3">Comments</h4>
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
        <a href="{{ route('staff.dashboard') }}" class="btn btn-dashboards m-2">Return</a>
        <button type="submit" class="btn btn-dashboard">Add Comment</button>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
