<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Submit Feedback</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Display&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

  <style>
    :root {
  --bs-body-font-family: 'Poppins', Arial, sans-serif;
  --bs-body-line-height: 1.4;
  --bs-body-bg: var(--bs-gray-100);
  --bs-body-color: #333;
  --bs-border-radius: 0.75rem;
  --bs-primary: #4e73df;
  --bs-success: #1cc88a;
  --bs-warning: #f6c23e;
  --bs-danger: #e74a3b;
  --bs-button: #243e69;
}

body {
  font-family: var(--bs-body-font-family);
  margin: 0;
  background-color: #8FABD4;
}

.navbar {
  background: #4A70A9;
}

.navbar-brand {
  font-family: Momo Trust Display;
  font-size: 20px;
  font-weight: 500;
  color: #fff !important;
  font-style: normal;
}

.navlink {
  color: #fff !important;
  font-weight: 500;
  border-radius: 6px;
  font-family: Momo Trust Display;
  font-style: normal;
  padding: 7px 10px;
  transition: all 0.3s ease;
  text-decoration: none;
}

.navlink:hover {
  background-color: #243e69;
  transform: scale(1.05);
}

.dropdown-menu {
  border-radius: 5px;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.dropdown-item:hover {
  background-color: #e4e4e4;
}

.card {
  border: none;
  border-radius: var(--bs-border-radius);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.alert-success {
  --bs-alert-bg: #d1e7dd;
  --bs-alert-border-color: #0f5132;
  --bs-alert-color: #0f5132;
  border-left: 6px solid #0f5132;
}

.btn-success {
  background-color: var(--bs-success);
  border-color: var(--bs-success);
  font-weight: 600;
  transition: all 0.3s ease;
}

.btn-success:hover {
  background-color: #17a673;
  border-color: #17a673;
  transform: scale(1.02);
}

.btn-primary {
  background-color: #2e59d9;
  border-color: #2e59d9;
  font-weight: 600;
}

.btn-primary:hover {
  background-color: #224abe;
  border-color: #224abe;
}

.retbtn {
  background-color: var(--bs-button);
  border-color: var(--bs-button);
  font-weight: 600;
  color: white;
  transition: all 0.3s ease;
}
.retbtn:hover {
  background-color: #4c80d2;
  color: white;
  transform: scale(1.02);
}

  </style>

</head>

<body>
  <nav class="navbar navbar-expand-lg py-3 px-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">ECHOCARE</a>
    </div>
  </nav>

  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card p-4 p-md-5">
          <h2 class="text-center text-primary mb-4 fw-semibold">Submit Your Feedback</h2>

          @if(session('success'))
          <div class="alert alert-success mb-4">{{ session('success') }}</div>
          @endif

          <form action="{{ route('customer.feedback.submit') }}" method="POST" class="needs-validation" novalidate>
    @csrf
    <div class="mb-3">
    <label for="category" class="form-label fw-semibold">Category</label>
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

<div class="mb-3">
    <label for="priority" class="form-label fw-semibold">Priority Level</label>
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

<div class="mb-3">
    <label for="description" class="form-label fw-semibold">Description</label>
    <textarea id="description" name="description" class="form-control" rows="5" placeholder="Enter your feedback details..." required>{{ old('description') }}</textarea>
    @error('description')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-success w-100 py-2 mt-2">Submit Feedback</button>
<a href="{{ url('/customer/dashboard') }}" class="btn retbtn w-100 py-2 mt-2">Return</a>

</form>

        </div>
      </div>
    </div>
  </div>
</body>
</html>
