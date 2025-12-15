<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reports</title>
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

/* NAVBAR */
.navbar {
  background-color: var(--nav-bg);
}
.navbar-brand {
  color: white !important;
  font-weight: 500;
  font-family: var(--brand-font);
}
/* CARDS */
.card-custom {
  background: white;
  border-radius: var(--radius);
  border: none;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.text-primary {
  color: var(--primary-color) !important;
}

/* BUTTONS */
.btn-dashboard {
  background-color: var(--primary-color);
  color: white;
  border-radius: 8px;
  padding: 10px 20px;
  font-weight: 500;
  width: 200px;
  transition: all 0.3s ease;
}
.btn-dashboard:hover {
  background-color: var(--hover-accent);
  transform: scale(0.98);
  color: white;
}
.btn{
  transition: all 0.3s ease;
}
.btn:hover{
  transform: scale(0.98);
}

/* TABLE */
table thead {
  background-color: #e8edf5;
}
table tbody tr:hover {
  background-color: #f5f7fb;
}
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg py-3 px-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ECHOCARE STAFF PORTAL</a>
  </div>
</nav>

<div class="container py-4">

  <div class="card card-custom p-4 mb-4">
    <h2 class="text-primary mb-2">Reports Overview</h2>
    <p class="mb-0">Analyze submissions, resolution performance, and unresolved cases.</p>
    <a href="{{ route('staff.dashboard') }}" class="btn btn-dashboard m-2">Dashboard</a>
  </div>

  <div class="card card-custom p-4 mb-4">
    <form method="GET" class="row g-3">
      <div class="col-md-4">
        <label class="fw-semibold">From</label>
        <input type="date" name="from" class="form-control" value="{{ $from }}">
      </div>
      <div class="col-md-4">
        <label class="fw-semibold">To</label>
        <input type="date" name="to" class="form-control" value="{{ $to }}">
      </div>
      <div class="col-md-4 d-flex align-items-end">
        <button class="btn btn-dashboard w-100">Filter</button>
      </div>
    </form>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="card card-custom p-4 text-center">
        <h5 class="text-primary">Total Submissions</h5>
        <h2 class="fw-bold">{{ $totalSubmitted }}</h2>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-custom p-4 text-center">
        <h5 class="text-primary">Total Resolved</h5>
        <h2 class="fw-bold text-success">{{ $totalResolved }}</h2>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card card-custom p-4 text-center">
        <h5 class="text-primary">Avg Resolution Time</h5>
        <h2 class="fw-bold text-warning">
          {{ $avgHours ? number_format($avgHours, 2).' hrs' : 'N/A' }}
        </h2>
      </div>
    </div>
  </div>

  <div class="card card-custom p-4 mb-4">
    <h4 class="text-primary mb-3">Feedback Trends (By Category)</h4>

    @if($feedbackTrends->isEmpty())
      <p class="text-muted">No submissions found for this date range.</p>
    @else
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Category</th>
              <th>Total Submissions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($feedbackTrends as $trend)
            <tr>
              <td>{{ $trend->CategoryID }}</td>
              <td>{{ $trend->total }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

  <div class="card card-custom p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="text-danger mb-0">Unresolved Cases</h4>
      <a href="{{ route('staff.reports.export.unresolved', ['from'=>$from, 'to'=>$to]) }}"
         class="btn btn-success">Download CSV</a>
    </div>

    @if($unresolved->isEmpty())
      <p class="text-muted">No unresolved cases in this date range.</p>
    @else
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Category</th>
              <th>Status</th>
              <th>Date Submitted</th>
            </tr>
          </thead>
          <tbody>
            @foreach($unresolved as $u)
            <tr>
              <td>{{ $u->SubmissionID }}</td>
              <td>{{ $u->CategoryID }}</td>
              <td>{{ $u->status }}</td>
              <td>{{ \Carbon\Carbon::parse($u->dateSubmitted)->format('M d, Y') }}</td>
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
