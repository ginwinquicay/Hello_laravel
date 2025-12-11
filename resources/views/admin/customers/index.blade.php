<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Customers</title>

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

.table thead {
  background-color: #e8edf5;
}
.table tbody tr:hover {
  background-color: #f5f7fb;
}
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg py-3 px-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">ECHOCARE ADMIN PORTAL</a>
    <a href="{{ route('logout.admin') }}" class="navlink">Log out</a>
  </div>
</nav>

<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="text-primary">Customer Accounts</h2>
    <div>
      <a href="{{ route('admin.staff.create') }}" class="btn btn-dashboard">Create New Account</a>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-dashboard ms-2">Dashboard</a>
    </div>
  </div>

  <div class="card card-custom p-4">
    @if($customers->isEmpty())
      <div class="alert alert-info">No customers found.</div>
    @else
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Customer ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Contact No</th>
              <th>Address</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($customers as $customer)
            <tr>
              <td>{{ $customer->CustomerID }}</td>
              <td>{{ $customer->Fname }}</td>
              <td>{{ $customer->Lname }}</td>
              <td>{{ $customer->email }}</td>
              <td>{{ $customer->contact_no }}</td>
              <td>{{ $customer->address }}</td>
              <td>
                <a href="{{ route('admin.customers.edit', $customer->CustomerID) }}" class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('admin.customers.delete', $customer->CustomerID) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
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
