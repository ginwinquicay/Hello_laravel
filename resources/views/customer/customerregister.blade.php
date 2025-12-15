<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Sign Up</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&family=Momo+Trust+Display&display=swap" rel="stylesheet">
<style>
  :root {
    --nav-bg: #4A70A9;
    --primary-color: #538ce1;
    --hover-accent: #4A70A9;
    --brand-font: "Momo Trust Display", sans-serif;
  }
  body {
    background-color: #e2e2e2;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    min-height: 100vh;
  }
  .navbar {
    background-color: var(--nav-bg);
    padding: 1rem 1.5rem;
  }
  .navbar-brand {
    color: #fff !important;
    font-family: var(--brand-font);
    font-size: 20px;
    font-weight: 500;
  }
  .nav-btn {
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
  .signup-wrapper {
    height: calc(100vh - 72px);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 10px;
  }
  .card {
    border-radius: 1.2rem;
    border: none;
  }
  .btn{
    transition: all 0.3s ease;
  }
  .btn:hover{
    transform: scale(0.98);
  }
  .btn-primary {
    background-color: var(--primary-color);
    border: none;
    transition: 0.3s ease;
  }
  .btn-primary:hover {
    background-color: var(--hover-accent);
    color: #fff;
  }
  a.text-primary {
    color: var(--primary-color) !important;
  }
  a.text-primary:hover {
    color: #000 !important;
  }
  .text:hover{
    color: purple;
  }
  .alert-danger{
    margin-top: 10px;
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

@if ($errors->any())
  <div class="alert alert-danger position-absolute start-50 translate-middle-x flash-success px-4 py-3">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="signup-wrapper">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg">
          <div class="card-body p-4">

            <h2 class="text-center mb-4">Sign Up</h2>

            <form method="POST" action="{{ url('/register-customer') }}">
              @csrf

              <div class="mb-3">
                <input type="text"
       name="Fname"
       class="form-control"
       placeholder="First Name"
       value="{{ old('Fname') }}"
       required>

              </div>

              <div class="mb-3">
                <input type="text"
       name="Lname"
       class="form-control"
       placeholder="Last Name"
       value="{{ old('Lname') }}"
       required>

              </div>

              <div class="mb-3">
                <input type="text"
       name="address"
       class="form-control"
       placeholder="Address"
       value="{{ old('address') }}"
       required>

              </div>

              <div class="mb-3">
                <input type="text"
       name="contact_no"
       class="form-control"
       placeholder="Contact Number"
       value="{{ old('contact_no') }}"
       required>

              </div>

              <div class="mb-3">
                <input type="email"
       name="email"
       class="form-control"
       placeholder="Email"
       value="{{ old('email') }}"
       required>

              </div>

              <div class="mb-3">
                <input type="password"
                  name="password"
                  class="form-control"
                  placeholder="Password"
                  minlength="8"
                  required>
              </div>

              <div class="mb-3">
                <input type="password"
                  name="password_confirmation"
                  class="form-control"
                  placeholder="Confirm Password"
                  minlength="8"
                  required>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Sign Up</button>
              </div>

              <p class="text-center mt-3 mb-0">
                Already have an account?
                <a href="{{ url('/login-customer') }}" class="text text-decoration-none">
                  Login here
                </a>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
