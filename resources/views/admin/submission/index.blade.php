<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Deleted Submissions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Display&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <style>
:root {
  --bs-body-font-family: 'Poppins', Arial, sans-serif;
  --main-bg: #e2e2e2;
  --nav-bg: #4A70A9;
  --primary-color: #4A70A9;
  --hover-accent: #538ce1;
  --radius: 0.75rem;
  --brand-font: "Momo Trust Display", sans-serif;
}
.badge-orange {
  background-color: #fd7e14 !important;
  color: white;
}
body {
  background-color: var(--main-bg);
  font-family: var(--bs-body-font-family);
}
.navbar {
  background-color: var(--nav-bg);
}
.navbar-brand {
  color: white !important;
  font-weight: 500;
  font-family: var(--brand-font);
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
.btn-dashboard {
  background-color: var(--primary-color);
  color: white;
  border-radius: 8px;
  padding: 10px 20px;
  font-weight: 500;
}
.btn-dashboard:hover {
  background-color: var(--hover-accent);
  transform: scale(1.05);
}
.table thead {
  background-color: #e8edf5;
}
.table tbody tr:hover {
  background-color: #f5f7fb;
}
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg py-3 px-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">ECHOCARE ADMIN PORTAL</a>
  </div>
</nav>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="text-primary">Soft Deleted Submissions</h2>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-dashboard">Dashboard</a>
  </div>

  <div class="card card-custom p-4">
    @if($submissions->isEmpty())
      <div class="alert alert-info">No soft-deleted submissions found.</div>
    @else
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer</th>
              <th>Category</th>
              <th>Priority</th>
              <th>Staff</th>
              <th>Status</th>
              <th>Date Submitted</th>
              <th>Description</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($submissions as $sub)
              @if($sub->is_deleted)
              <tr>
                <td>{{ $sub->SubmissionID }}</td>
                <td>{{ $sub->customer?->Fname ?? 'N/A' }} {{ $sub->customer?->Lname ?? '' }}</td>
                <td>{{ $sub->category?->categoryname ?? 'N/A' }}</td>
                <td>
                    @php $priority = $sub->priority?->priorityname; @endphp
                    <span class="badge
                    @if($priority === 'Critical') bg-danger
                    @elseif($priority === 'High') badge-orange
                    @elseif($priority === 'Medium') bg-warning text-dark
                    @elseif($priority === 'Low') bg-success
                    @else bg-secondary
                    @endif">
                    {{ $priority ?? 'N/A' }}
                    </span>
                </td>
                <td>{{ $sub->staff?->Lname ?? '' }}</td>
                <td>{{ $sub->status }}</td>
                <td>{{ \Carbon\Carbon::parse($sub->dateSubmitted)->format('M d, Y') }}</td>
                <td>{{ Str::limit($sub->description, 50) }}</td>
                <td>
                  <!-- Restore Form -->
                  <form action="{{ route('admin.submissions.restore', $sub->SubmissionID) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm mb-1">Restore</button>
                  </form>

                  <!-- Permanent Delete Form -->
                  <form action="{{ route('admin.submissions.forceDelete', $sub->SubmissionID) }}" method="POST" class="d-inline" onsubmit="return confirm('This will permanently delete the submission. Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm mb-1">Delete</button>
                  </form>
                </td>
              </tr>
              @endif
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
