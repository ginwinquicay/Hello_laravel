<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Display&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
<style>
:root {
  --main-bg: #e2e2e2;
  --nav-bg: #4A70A9;
  --primary-color: #5e8cd2;
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
  opacity: 0.8;
}
.card-custom {
  background: white;
  border-radius: var(--radius);
  border: none;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.text-primary {
  color: var(--primary-color) !important;
}
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
  color: white;
  transform: scale(0.98);
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
    <a class="navbar-brand" href="#">ECHOCARE STAFF PORTAL</a>
    <a href="{{ url('/logout-customer') }}" class="navlink">Log out</a>
  </div>
</nav>

<div class="container py-4">

  {{-- Flash Messages --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="card card-custom p-4 mb-4">
    <h2 class="text-primary mb-2">
      Welcome, {{ Auth::guard('staff')->user()->Fname ?? 'Staff' }}!
    </h2>
    <p class="mb-3">
      Here is your staff dashboard. You can manage submissions, update statuses,
      and monitor system activity.
    </p>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="card card-custom p-4 text-center">
        <h4 class="text-primary">Pending Requests</h4>
        <h2 class="fw-bold">{{ $submissions->where('status','Pending')->count() }}</h2>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-custom p-4 text-center">
        <h4 class="text-primary">In Progress</h4>
        <h2 class="fw-bold">{{ $submissions->where('status','In Progress')->count() }}</h2>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-custom p-4 text-center">
        <h4 class="text-primary">Resolved</h4>
        <h2 class="fw-bold text-success">
          {{ $submissions->whereIn('status', ['Resolved', 'Closed'])->count() }}
        </h2>
      </div>
    </div>
  </div>

  <div class="card card-custom p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="text-primary mb-0">Your Assigned Submissions</h3>
      <a href="{{ route('staff.reports') }}" class="btn btn-dashboard">Generate Report</a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Category</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($submissions as $submission)
          <tr>
            <td>{{ $submission->SubmissionID }}</td>
            <td>{{ $submission->customer->Fname ?? 'N/A' }} {{ $submission->customer->Lname ?? '' }}</td>
            <td>{{ $submission->category->categoryname ?? 'N/A' }}</td>
            <td>
              @php
                $status = strtolower($submission->status);
                $badge = 'secondary';
                if($status == 'pending') $badge = 'warning';
                elseif($status == 'in progress') $badge = 'info';
                elseif($status == 'resolved') $badge = 'success';
                elseif($status == 'deleted') $badge = 'secondary';
                elseif($status == 'closed') $badge = 'dark';
              @endphp
              <span class="badge bg-{{ $badge }}">{{ $submission->status }}</span>
            </td>
            <td>{{ \Carbon\Carbon::parse($submission->dateSubmitted)->format('M d, Y') }}</td>
            <td>
              @if($submission->status !== 'Closed')
                <a href="{{ route('staff.submission.show', $submission->SubmissionID) }}"
                   class="btn btn-sm btn-primary">View</a>
              @else
                <span class="text-muted fst-italic">Closed</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center">No submissions assigned to you.</td>
          </tr>
          @endforelse
        </tbody>
      </table>

      {{ $submissions->links() }}
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
