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
    .text-primary{
      
    }
    .content-box {
      max-width: 700px;
      margin: 50px auto 30px;
      background: #e2e2e2;
      padding: 30px;
      border-radius: 15px;
    }
    .login-container {
      max-width: 500px;
      margin: 0 auto 50px;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .login-btn {
      display: block;
      width: 200px;
      background: #4A70A9;
      color: #fff;
      padding: 12px;
      border-radius: 30px;
      font-weight: 500;
      text-decoration: none;
      margin-bottom: 15px;
    }
    .login-btn:hover {
      background-color: #243e69;
      color: #fff;
    }
    .sbtn {
      background: #4A70A9;
      color: #fff;
      padding: 12px 30px;
      border-radius: 30px;
      font-weight: 500;
      text-decoration: none;
    }
    .sbtn:hover {
      background-color: #243e69;
      color: #fff;
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
  <h3 class="fw-bold mb-3">Welcome to ECHOCARE</h3>
  <p>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod possimus deserunt,
    aut odit placeat deleniti dolores, necessitatibus repellat temporibus beatae
    repudiandae dolore quasi nam a quo inventore.
  </p>
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
