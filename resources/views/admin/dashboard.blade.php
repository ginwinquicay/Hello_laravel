<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- GOOGLE FONTS -->
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
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg py-3 px-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ECHOCARE ADMIN PORTAL</a>
    <a href="{{ route('logout.admin') }}" class="navlink">Log out</a>
  </div>
</nav>

<div class="container py-4">

  <!-- WELCOME CARD -->
  <div class="card card-custom mb-4 p-4">
    <h2 class="text-primary mb-3">
      Welcome, {{ Auth::guard('admin')->user()->Fname ?? 'Admin' }}!
    </h2>
    <p>This is your administrator dashboard. Manage customers, staff, categories, priorities, and invalid submissions.</p>
  </div>

  <!-- QUICK STATS -->
  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="card card-custom p-4 text-center">
        <h4 class="text-primary">Total Customers</h4>
        <h2 class="fw-bold">{{ $customersCount }}</h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-custom p-4 text-center">
        <h4 class="text-primary">Total Staff</h4>
        <h2 class="fw-bold">{{ $staffCount }}</h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-custom p-4 text-center">
        <h4 class="text-primary">Total Submissions</h4>
        <h2 class="fw-bold">{{ $submissionsCount }}</h2>
      </div>
    </div>
  </div>

  <!-- MANAGEMENT PANELS -->
  <div class="row g-4">

    <!-- MANAGE CUSTOMERS -->
    <div class="col-md-6">
      <div class="card card-custom p-4">
        <h4 class="text-primary">Manage Customer Accounts</h4>
        <p>Create, update, or delete customer accounts.</p>
        <a href="{{ route('admin.customers') }}" class="btn btn-dashboard w-100">Go to Customers</a>
      </div>
    </div>

    <!-- MANAGE STAFF -->
    <div class="col-md-6">
      <div class="card card-custom p-4">
        <h4 class="text-primary">Manage Staff Accounts</h4>
        <p>Create new staff members or modify existing ones.</p>
        <a href="{{ route('admin.staff') }}" class="btn btn-dashboard w-100">Go to Staff</a>
      </div>
    </div>

    <!-- CATEGORIES & PRIORITIES -->
    <div class="col-md-6">
      <div class="card card-custom p-4">
        <h4 class="text-primary">Categories & Priorities</h4>
        <p>Configure submission categories and priority levels.</p>
        <a href="{{ route('admin.categories') }}" class="btn btn-dashboard w-100">Configure</a>
      </div>
    </div>

    <!-- DELETE INVALID SUBMISSIONS -->
    <div class="col-md-6">
      <div class="card card-custom p-4">
        <h4 class="text-primary">Delete Test / Invalid Submissions</h4>
        <p>Remove spam, test, or invalid submissions from the system.</p>
        <a href="{{ route('admin.submissions') }}" class="btn btn-dashboard w-100">Review & Delete</a>
      </div>
    </div>

  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
