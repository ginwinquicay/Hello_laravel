<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&family=Momo+Trust+Display&display=swap" rel="stylesheet">
  <style>
    :root {
      --nav-bg: #4A70A9;
      --primary-color: #4A70A9;
      --hover-accent: #538ce1;
      --brand-font: "Momo Trust Display", sans-serif;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #e2e2e2;
      min-height: 100vh;
      margin: 0;
      color: #1f2d3d;
    }
    .navbar {
      background-color: var(--nav-bg);
      padding: 1rem 1.5rem;
    }
    .navbar-brand {
      color: #fff !important;
      font-size: 20px;
      font-weight: 500;
      font-family: Momo Trust Display;
      font-style: normal;
      }
    .nav-btn {
      background: var(--primary-color);
      color: #fff !important;
      padding: 7px 10px;
      border-radius: 6px;
      font-weight: 500;
      font-family: "Momo Trust Display", sans-serif;
      text-decoration: none;
    }
    .nav-btn:hover {
      background-color: #243e69;
      color: #fff !important;
      opacity: 0.95;
    }
    .page-wrapper {
      height: calc(100vh - 72px);
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-card {
      width: 400px;
      background: #fff;
      padding: 40px 35px;
      border-radius: 20px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      text-align: center;
    }
    .login-card h2 {
      font-weight: 600;
      margin-bottom: 25px;
    }
    .form-control {
      border-radius: 10px;
      padding: 12px;
      font-size: 15px;
      border: 1px solid #b8c6d9;
    }
    .btn-custom {
      width: 100%;
      background: var(--primary-color);
      border: none;
      padding: 12px;
      font-size: 16px;
      color: white;
      border-radius: 10px;
      font-weight: 500;
      transition: 0.2s;
    }
    .btn-custom:hover {
      background-color: var(--hover-accent);
    }
    .alert-success {
      background: var(--primary-color);
      color: white;
      border-radius: 10px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      z-index: 999;
    }
  </style>
</head>

<body>

<nav class="navbar">
  <div class="container-fluid">
    <span class="navbar-brand">ECHOCARE</span>
    <a href="{{ route('home') }}" class="nav-btn">GO BACK</a>
  </div>
</nav>

@if (session('success'))
  <div class="alert-success position-absolute top-0 start-50 translate-middle-x mt-4 px-4 py-3">
    {{ session('success') }}
  </div>
@endif

<div class="page-wrapper">
  <div class="login-card">
    <form method="POST" action="{{ url('/login-admin') }}">
      @csrf

      <h2>Admin Login</h2>

      <div class="mb-3">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
      </div>

      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>

      <button type="submit" class="btn btn-custom mt-2">Login</button>
    </form>
  </div>
</div>

</body>
</html>
