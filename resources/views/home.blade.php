<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EchoCare Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Display&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #e2e2e2;
    }
    .navbar {
      background: #4A70A9;
    }
    .navbar-brand {
      color: #fff !important;
      font-size: 20px;
      font-weight: 500;
      font-family: "Momo Trust Display", sans-serif;
    }
    .content-box {
      color: #0049b7;
      max-width: 700px;
      margin: 130px auto 20px;
      background: #e2e2e2;
    }
    .login-container {
      max-width: 400px;
      margin: 30px auto 0;
      background: transparent;
      padding: 30px;
      border-radius: 15px;
    }
    .login-btn {
      display: block;
      width: 100%;
      background: #6494da;
      color: #fff;
      padding: 14px 0;       
      border-radius: 30px;
      font-weight: 500;
      font-size: 25px;        
      text-decoration: none;
      margin-bottom: 12px;
      text-align: center;
      transition: all 0.3s ease;
    }
    .login-btn:hover {
      background-color: #4A70A9;
      color: #fff;
      transform: scale(0.97);
    }
  </style>
</head>

<body>

<nav class="navbar navbar-expand-lg py-3 px-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ECHOCARE</a>
  </div>
</nav>

<div class="content-box text-center">
  <h3 class="fw-bold mb-3">EchoCare Services</h3>
</div>

<div class="login-container text-center">
  <h5 class="fw-bold mb-4">Log in as</h5>
  <a href="{{ url('/login-customer') }}" class="login-btn">User</a>
  <a href="{{ url('/login-staff') }}" class="login-btn">Staff</a>
  <a href="{{ url('/login-admin') }}" class="login-btn">Admin</a>
  <a href="{{ url('/register-customer') }}" class="login-btn">Sign up</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
