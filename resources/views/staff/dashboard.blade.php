<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Dashboard</title>

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- GOOGLE FONTS -->
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

/* GLOBAL */
body {
  background-color: var(--main-bg);
  font-family: var(--bs-body-font-family);
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

/* NAV LINK */
.navlink {
  color: #fff !important;
  font-weight: 500;
  border-radius: 6px;
  font-family: var(--brand-font);
  padding: 7px 10px;
  text-decoration: none;
  transition: 0.3s ease;
}

.navlink:hover {
  background-color: red;
  opacity: 0.8;
  transform: scale(1.05);
}

/* SIDEBAR */
.sidebar {
  background: var(--sidebar-bg);
  min-height: 100vh;
}

.sidebar .nav-link {
  color: white;
  font-weight: 500;
  border-radius: 8px;
}

.sidebar .nav-link:hover {
  background-color: var(--main-bg);
  color: #000;
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

/* BUTTON */
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

  <!-- NAVBAR -->
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
      <a href="{{ route('staff.reports') }}" class="nav-link py-2 px-3 mb-1">Reports</a>
      <a href="#" class="nav-link py-2 px-3 mb-1">Settings</a>
    </nav>
  </div>

  <!-- MAIN CONTENT -->
  <div class="col-md-9 col-lg-10 p-4">

    <!-- WELCOME CARD -->
    <div class="card card-custom p-4 mb-4">
      <h2 class="text-primary mb-2">
        Welcome, {{ Auth::guard('staff')->user()->Fname ?? 'Staff' }}!
      </h2>
      <p class="mb-3">
        Here is your staff dashboard. You can manage submissions, update statuses,
        and monitor system activity.
      </p>
    </div>

    <!-- QUICK STATS -->
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
          <h2 class="fw-bold">{{ $submissions->where('status','Resolved')->count() }}</h2>
        </div>
      </div>
    </div>

    <!-- TABLE OF TASKS -->
    <div class="card card-custom p-4">
      <h3 class="text-primary mb-3">Your Assigned Submissions</h3>

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
                <a href="{{ route('staff.submission.show', $submission->SubmissionID) }}" class="btn btn-sm btn-dashboard">View</a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center">No submissions assigned to you.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        {{ $submissions->links() }} <!-- Pagination links -->
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>
