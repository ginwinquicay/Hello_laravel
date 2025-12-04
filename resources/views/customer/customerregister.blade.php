<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Sign Up</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<style>
  body {
    background-color: #8FABD4;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Poppins', sans-serif;
    margin: 0;
  }

  .signup-container {
    width: 100%;
  }

  .card {
    border-radius: 1.2rem;
    border: none;
  }

  .btn-primary {
    background-color: #4A70A9;
    border: none;
    transition: all 0.3s ease;
    font-weight: 600;
  }

  .btn-primary:hover {
    opacity: 0.9;
    color: #ffffff;
    background-color: #538ce1
  }

  a.text-primary {
    color: #4A70A9 !important;
  }

  a.text-primary:hover {
    color: #000000 !important;

  }
</style>

</head>
<body>

  <div class="container signup-container">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-4">
        <div class="card shadow-lg">
          <div class="card-body p-4">
            
            <h2 class="text-center mb-4 fw-semibold">Sign Up</h2>

            <form method="POST" action="{{ url('/register-customer') }}">
              @csrf

              <div class="mb-3">
                <input type="text" name="Fname" class="form-control" placeholder="First Name" required>
              </div>

              <div class="mb-3">
                <input type="text" name="Lname" class="form-control" placeholder="Last Name" required>
              </div>

              <div class="mb-3">
                <input type="text" name="address" class="form-control" placeholder="Address" required>
              </div>

              <div class="mb-3">
                <input type="text" name="contact_no" class="form-control" placeholder="Contact Number" required>
              </div>

              <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
              </div>

              <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
              </div>

              <div class="mb-3">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Sign Up</button>
              </div>

              <p class="text-center mt-3 mb-0">
                Already have an account?
                <a href="{{ url('/login-customer') }}" class="text-decoration-none text-primary fw-semibold">
                  Login here
                </a>
              </p>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
