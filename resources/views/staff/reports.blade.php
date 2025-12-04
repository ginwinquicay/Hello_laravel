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
  --bs-body-font-family: 'Poppins', Arial, sans-serif;
  --main-bg: #8FABD4;
  --nav-bg: #4A70A9;
  --sidebar-bg: #3c567d;
  --primary-color: #4A70A9;
  --hover-accent: #538ce1;
  --radius: 0.75rem;
  --brand-font: "Momo Trust Display", sans-serif;
}

body {
  background-color: var(--main-bg);
  font-family: var(--bs-body-font-family);
}

.navbar { background-color: var(--nav-bg); }

.navbar-brand {
  color: white !important;
  font-weight: 500;
  font-family: var(--brand-font);
}

.navlink {
  color: #fff !important;
  font-weight: 500;
  border-radius: 6px;
  padding: 7px 10px;
  text-decoration: none;
}

.sidebar {
  background: var(--sidebar-bg);
  min-height: 100vh;
}

.sidebar .nav-link {
  color: white;
  font-weight: 500;
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
}

.btn-dashboard:hover {
  background-color: var(--hover-accent);
  transform: scale(1.05);
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

<div class="container-fluid">
  <div class="row">

    <!-- SIDEBAR -->
    <div class="col-md-3 col-lg-2 sidebar p-3">
      <nav class="nav flex-column">
        <a href="{{ route('staff.dashboard') }}" class="nav-link py-2 px-3 mb-1">Dashboard</a>
        <a href="#" class="nav-link py-2 px-3 mb-1">Manage Requests</a>
        <a href="{{ route('staff.reports') }}" class="nav-link py-2 px-3 mb-1 bg-light text-dark">Reports</a>
        <a href="#" class="nav-link py-2 px-3 mb-1">Settings</a>
      </nav>
    </div>

    <!-- MAIN CONTENT -->
    <div class="col-md-9 col-lg-10 p-4">

      <div class="card card-custom p-4 mb-4">

        <h2 class="text-primary mb-4">Reports Overview</h2>

        <!-- DATE FILTER -->
        <form method="GET" class="row mb-4">
          <div class="col-md-4">
            <label>From:</label>
            <input type="date" name="from" class="form-control" value="{{ $from }}">
          </div>
          <div class="col-md-4">
            <label>To:</label>
            <input type="date" name="to" class="form-control" value="{{ $to }}">
          </div>
          <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-dashboard w-100">Filter</button>
          </div>
        </form>

        <!-- SUMMARY CARDS -->
        <div class="row mb-4">

          <div class="col-md-4">
            <div class="card card-custom p-3 text-center">
              <h5>Total Submissions</h5>
              <h2 class="text-primary">{{ $totalSubmitted }}</h2>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card card-custom p-3 text-center">
              <h5>Total Resolved</h5>
              <h2 class="text-success">{{ $totalResolved }}</h2>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card card-custom p-3 text-center">
              <h5>Avg Resolution Time</h5>
              <h2 class="text-warning">
                {{ $avgHours ? number_format($avgHours, 2) . ' hrs' : 'N/A' }}
              </h2>
            </div>
          </div>

        </div>

        <!-- FEEDBACK TRENDS -->
        <div class="card card-custom p-4 mb-4">
          <h4 class="text-primary mb-3">Feedback Trends (By Category)</h4>

          @if($feedbackTrends->isEmpty())
            <p class="text-muted">No submissions found for this date range.</p>
          @else
            <table class="table table-bordered">
              <thead class="table-light">
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
          @endif
        </div>

        <!-- UNRESOLVED CASES -->
        <div class="card card-custom p-4 mb-4">
          <h4 class="text-danger mb-3">Unresolved Cases</h4>

            <a href="{{ route('staff.reports.export.unresolved', ['from'=>$from, 'to'=>$to]) }}"
            class="btn btn-success">Download CSV</a>

          @if($unresolved->isEmpty())
            <p class="text-muted">No unresolved cases in this date range.</p>
          @else
            <table class="table table-bordered">
              <thead class="table-light">
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
          @endif
        </div>

      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
