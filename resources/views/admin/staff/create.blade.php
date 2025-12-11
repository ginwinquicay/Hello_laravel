<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Staff</title>

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- GOOGLE FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Display&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

  <style>
:root { --bs-body-font-family: 'Poppins', Arial, sans-serif; --main-bg: #8FABD4; --nav-bg: #4A70A9; --primary-color: #4A70A9; --hover-accent: #538ce1; --radius: 0.75rem; --brand-font: "Momo Trust Display", sans-serif; }
body { background-color: var(--main-bg); font-family: var(--bs-body-font-family); }
.navbar { background-color: var(--nav-bg); }
.navbar-brand { color: white !important; font-weight: 500; font-family: var(--brand-font); }
.navlink { color: #fff !important; font-weight: 500; border-radius: 6px; font-family: var(--brand-font); padding: 7px 10px; text-decoration: none; transition: 0.3s ease; }
.navlink:hover { background-color: red; opacity: 0.8; transform: scale(1.05); }
.card-custom { background: white; border-radius: var(--radius); border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
.text-primary { color: var(--primary-color) !important; font-weight: 600; }
.btn-dashboard { background-color: var(--primary-color); color: white; border-radius: 8px; padding: 10px 20px; font-weight: 500; }
.btn-dashboard:hover { background-color: var(--hover-accent); transform: scale(1.05); }
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
    <h2 class="text-primary">Create New Staff</h2>
    <a href="{{ route('admin.staff') }}" class="btn btn-dashboard">Back to Staff</a>
  </div>

  <div class="card card-custom p-4">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.staff.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="Fname" class="form-label">First Name</label>
        <input type="text" class="form-control" id="Fname" name="Fname" value="{{ old('Fname') }}" required>
      </div>

      <div class="mb-3">
        <label for="Lname" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="Lname" name="Lname" value="{{ old('Lname') }}" required>
      </div>

      <div class="mb-3">
        <label for="Lname" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <div class="mb-3">
        <label for="contact_no" class="form-label">Contact Number</label>
        <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ old('contact_no') }}" required>
      </div>

      <button type="submit" class="btn btn-dashboard">Create Staff</button>
    </form>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
