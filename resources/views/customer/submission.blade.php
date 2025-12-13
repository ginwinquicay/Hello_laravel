<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Submit Feedback</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Display&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

<style>
:root {
  --main-bg: #e2e2e2;
  --nav-bg: #4A70A9;
  --primary-color: #4cb06c;
  --secodary-color: #6494da;
  --hover-accent: #25783e;
  --hover-accent2: #486591;
  --radius: 0.75rem;
  --brand-font: "Momo Trust Display", sans-serif;
}

body {
  background-color: var(--main-bg);
  font-family: 'Poppins', Arial, sans-serif;
  margin: 0;
}

/* NAVBAR */
.navbar {
  background-color: var(--nav-bg);
}
.navbar-brand {
  color: white !important;
  font-weight: 500;
  font-family: var(--brand-font);
}
.navlink {
  color: white !important;
  font-weight: 500;
  font-family: var(--brand-font);
  text-decoration: none;
  padding: 7px 10px;
}
.navlink:hover {
  background-color: red;
  opacity: 0.8;
  transform: scale(1.05);
}

/* CARD */
.card-custom {
  background: white;
  border-radius: var(--radius);
  border: none;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* BUTTONS */
.btn-feedback, .btn-primary {
  background-color: var(--primary-color);
  color: white;
  border-radius: 8px;
  font-weight: 500;
  padding: 10px 20px;
  width: 250px;
  min-width: 150px;
  transition: all 0.3s ease;
}
.btn-feedback:hover, .btn-primary:hover {
  background-color: var(--hover-accent);
  color: white;
  transform: scale(1.04);
}

.btn-ret {
  background-color: var(--secodary-color);
  border-radius: 8px;
  font-weight: 500;
  color: white;
  padding: 10px 20px;
  width: 250px;
  min-width: 150px;
  text-decoration: none;
  display: inline-block;
  text-align: center;
  transition: all 0.3s ease;
}
.btn-ret:hover {
  background-color: var(--hover-accent2);
  color: white;
  transform: scale(1.04);
}

/* FORM LABELS */
.form-label {
  font-weight: 600;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg py-3 px-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ECHOCARE</a>
  </div>
</nav>

<!-- FEEDBACK FORM -->
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card card-custom p-4 p-md-5 text-center">
        <h2 class="text-primary mb-4 fw-semibold">Submit Your Feedback</h2>

        @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('customer.feedback.submit') }}" method="POST" class="needs-validation" novalidate>
          @csrf

          <div class="mb-3 text-start">
            <label for="category" class="form-label">Category</label>
            <select id="category" name="category" class="form-select" required>
              <option value="">Select Category</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->CategoryID }}" {{ old('category') == $cat->CategoryID ? 'selected' : '' }}>
                  {{ $cat->categoryname }}
                </option>
              @endforeach
            </select>
            @error('category')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 text-start">
            <label for="priority" class="form-label">Priority Level</label>
            <select id="priority" name="priority" class="form-select">
              <option value="">Select Priority</option>
              @foreach($priorities as $p)
                <option value="{{ $p->PriorityID }}" {{ old('priority') == $p->PriorityID ? 'selected' : '' }}>
                  {{ $p->priorityname }}
                </option>
              @endforeach
            </select>
            @error('priority')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 text-start">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control" rows="5" placeholder="Enter your feedback details..." required>{{ old('description') }}</textarea>
            @error('description')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="d-flex flex-column align-items-center gap-2 mt-3">
            <button type="submit" class="btn btn-feedback">Submit Feedback</button>
            <a href="{{ url('/customer/dashboard') }}" class="btn-ret">Return</a>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
