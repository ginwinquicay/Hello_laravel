<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>EchoCare Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Display&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <style>
      body {
          font-family: 'Poppins', sans-serif;
          background-color: #8FABD4;
      }

      .navbar {
          background: #4A70A9;
      }

      .navbar-brand {
          color: #fff !important;
          font-size: 20px;
          font-weight: 500;
          font-family: Momo Trust Display;
          font-style: normal;
      }

      .nav-link{
          color: #fff !important;
          font-weight: 500;
          border-radius: 6px;
          font-family: Momo Trust Display;
          font-style: normal;
          padding: 7px 10px;
          transition: all 0.3s ease;
      }

      .nav-link:hover {
        color: black;
        background-color: #243e69;
        border-radius: 6px;
        transform: scale(1.05);
      }

      .content-box {
          max-width: 700px;
          margin: 50px auto;
          background: #fff;
          padding: 30px;
          border-radius: 15px;
          box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      }

      .sbtn {
          background: #4A70A9;
          color: #fff;
          padding: 12px 30px;
          border-radius: 30px;
          font-weight: 500;
          text-decoration: none;
          box-shadow: 0 4px 10px rgba(0,0,0,0.1);
          transition: all 0.3s ease;
          transform: scale(1.05);
      }

      .sbtn:hover {
          opacity: .9;
          color: #ffffff;
          background-color: #243e69;
      }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg py-3 px-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">ECHOCARE</a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown">
              Log in
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ url('/login-customer') }}">Customer</a></li>
              <li><a class="dropdown-item" href="{{ url('/login-staff') }}">Staff</a></li>
              <li><a class="dropdown-item" href="{{ url('/login-admin') }}">Admin</a></li>
            </ul>
          </li>
        </ul>
      </div>

    </div>
  </nav>

  <div class="content-box text-center">
    <h3 class="fw-bold mb-3">Welcome to ECHOCARE</h3>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod possimus deserunt, aut odit placeat deleniti dolores, necessitatibus repellat temporibus beatae repudiandae dolore quasi nam a quo inventore. Nisi, fugit sit.</p>
  </div>

  <div class="text-center mb-5">
    <a href="{{ url('/register-customer') }}" class="sbtn">Sign up</a>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
          crossorigin="anonymous"></script>

</body>
</html>
