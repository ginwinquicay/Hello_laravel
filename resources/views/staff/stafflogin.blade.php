<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Staff Login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #8FABD4;
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

    .form-control {
      border-radius: 10px;
      padding: 12px;
      font-size: 15px;
      border: 1px solid #b8c6d9;
    }

    .btn-custom {
      width: 100%;
      background: #4A70A9;
      border: none;
      padding: 12px;
      color: #fff;
      border-radius: 10px;
      font-weight: 500;
    }
  </style>
</head>

<body>
  <div class="login-card">

    @if($errors->any())
      <div class="alert alert-danger p-2">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ url('/login-staff') }}">
      @csrf
      <h2>Staff Login</h2>

      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
      </div>

      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>

      <button type="submit" class="btn btn-custom mt-2">Login</button>
    </form>
  </div>

</body>
</html>
