<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin Login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
          crossorigin="anonymous"></script>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #8FABD4; /* NEW BACKGROUND */
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #1f2d3d;
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
      color: #1f2d3d; /* Dark navy to match palette */
    }

    .form-control {
      border-radius: 10px;
      padding: 12px;
      font-size: 15px;
      color: #1f2d3d;
      border: 1px solid #b8c6d9;
    }

    .form-control::placeholder {
      color: #7c8ba1;
    }

    .btn-custom {
      width: 100%;
      background: #4A70A9; /* NEW BUTTON COLOR */
      border: none;
      padding: 12px;
      font-size: 16px;
      color: #fff; /* White text for contrast */
      border-radius: 10px;
      font-weight: 500;
      transition: 0.2s;
    }

    .btn-custom:hover {
      opacity: 0.9;
      color: #ffffff;
      background-color: #538ce1
    }
  </style>
</head>

<body>
  <div class="login-card">
    <form method="POST" action="{{ url('/login-admin') }}">
      @csrf
      <h2>Admin Login</h2>

      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Username" required>
      </div>

      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>

      <button type="submit" class="btn btn-custom mt-2">Login</button>
    </form>
  </div>

</body>
</html>
