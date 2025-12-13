<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Display&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

<style>
:root {
  --main-bg: #e2e2e2;
  --nav-bg: #4A70A9;
  --primary-color: #4A70A9;
  --hover-accent: #3e639a;
  --radius: 0.75rem;
  --brand-font: "Momo Trust Display", sans-serif;
}
body {
  background-color: var(--main-bg);
  font-family: 'Poppins', Arial, sans-serif;
  margin: 0;
}
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
}
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
.btn-feedback {
  background-color: #6494da;
  color: white;
  border-radius: 8px;
  padding: 8px 20px;
  font-weight: 500;
  width: 250px;
  min-width: 150px;
  transition: all 0.3s ease;
}
.btn-feedback:hover {
  background-color: var(--hover-accent);
  color: white;
  transform: scale(1.04);
}
table thead {
  background-color: #e8edf5;
}
table tbody tr:hover {
  background-color: #f5f7fb;
}
.badge {
  font-size: 0.8rem;
}
.badge-orange {
  background-color: #fd7e14 !important;
  color: white;
}
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg py-3 px-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ECHOCARE</a>
    <a href="{{ url('/logout-customer') }}" class="navlink">Log out</a>
  </div>
</nav>

<div class="container py-4">

  <div class="card card-custom mb-4 p-4">
    <h2 class="text-primary mb-3">
      Welcome, {{ Auth::guard('customer')->user()->Fname ?? 'Customer' }}!
    </h2>
    <p>This is your personalized dashboard. From here, you can manage your submissions, update your profile, and view your submission history.</p>
    <a href="{{ url('/customer/feedback') }}" class="btn btn-feedback fw-semibold">Submit Feedback</a>
  </div>

  <div class="card card-custom p-4 shadow-sm border-0">
    <h2 class="text-primary mb-3">Your Submissions</h2>

    @if($submissions->isEmpty())
      <div class="alert alert-info mb-0">
        You have no submissions made yet.
      </div>
    @else
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Category</th>
              <th>Priority</th>
              <th>Description</th>
              <th>Status</th>
              <th>Date Submitted</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($submissions as $submission)
            <tr>
              <td>{{ $submission->SubmissionID }}</td>
              <td>{{ $submission->category?->categoryname ?? 'N/A' }}</td>
              <td>
                <span class="badge 
                  @if($submission->priority?->priorityname == 'Critical') bg-danger
                  @elseif($submission->priority?->priorityname == 'High') badge-orange
                  @elseif($submission->priority?->priorityname == 'Medium') bg-warning
                  @elseif($submission->priority?->priorityname == 'Low') bg-success
                  @else bg-secondary @endif">
                  {{ ucfirst($submission->priority?->priorityname ?? 'N/A') }}
                </span>
              </td>
              <td>{{ $submission->description }}</td>
              <td>
                @php
                  $status = strtolower($submission->status);
                  $badge = 'secondary';
                  if($status == 'pending') $badge = 'warning';
                  elseif($status == 'in progress') $badge = 'info';
                  elseif($status == 'resolved') $badge = 'success';
                  elseif($status == 'closed') $badge = 'dark';
                @endphp
                <span class="badge bg-{{ $badge }}">{{ ucfirst($submission->status) }}</span>
              </td>
              <td>{{ $submission->created_at->format('M d, Y') }}</td>
              <td>
                <a href="{{ route('submission.edit', $submission->SubmissionID) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('submission.destroy', $submission->SubmissionID) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger"
                      onclick="return confirm('Are you sure you want to delete this submission?')">
                    Delete
                  </button>
                </form>
                <button class="btn btn-sm btn-secondary mt-1" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#comments-{{ $submission->SubmissionID }}" aria-expanded="false" 
                    aria-controls="comments-{{ $submission->SubmissionID }}">
                  View Comments
                </button>
              </td>
            </tr>
            <tr>
              <td colspan="7" class="p-0">
                <div class="collapse" id="comments-{{ $submission->SubmissionID }}">
                  <div class="card card-custom m-2 p-3">
                    <h6 class="text-primary mb-2">Staff Comments</h6>

                    @forelse($submission->comments as $comment)
                      <div class="border rounded p-2 mb-1">
                        <strong>{{ $comment->staff->Fname ?? 'Staff' }}:</strong>
                        {{ $comment->comment }}
                        @if($comment->action_taken)
                          <div><em>Action taken: {{ $comment->action_taken }}</em></div>
                        @endif
                        <small class="text-muted">{{ $comment->created_at->format('M d, Y H:i') }}</small>
                      </div>
                    @empty
                      <div class="text-muted">No comments yet.</div>
                    @endforelse
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
