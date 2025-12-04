<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Submission</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Momo+Trust+Display&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

  <style>
    :root {
      --bs-body-font-family: 'Poppins', Arial, sans-serif;
      --bs-body-bg: #f4f6f9;
      --bs-primary: #4e73df;
      --bs-success: #1cc88a;
      --bs-border-radius: 0.75rem;
    }

    body {
      font-family: var(--bs-body-font-family);
      background-color: #8FABD4;
      margin: 0;
      color: #333;
    }

    .navbar {
      background-color: #4A70A9;
    }

    .navbar-brand {
      color: white !important;
      font-weight: 500;
      font-family: Momo Trust Display;
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
      background-color: rgba(255, 0, 0, 0.832);
      color: white;
      transform: scale(1.05);
    }

    .card-custom {
      border-radius: 1rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      background-color: #fff;
    }

    .btn-primary {
      background-color: #4e73df;
      border: none;
      transition: 0.3s;
    }

    .btn-primary:hover {
      background-color: #2e59d9;
      transform: scale(1.05);
    }

    .btn-success {
      background-color: #1cc88a;
      border: none;
      transition: 0.3s;
    }

    .btn-success:hover {
      background-color: #17a673;
      transform: scale(1.05);
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
    <div class="card card-custom mx-auto p-4" style="max-width: 700px;">
      <h3 class="text-primary mb-4">Edit Submission</h3>

      <form method="POST" action="{{ route('submission.update', $submission->SubmissionID) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label for="description" class="form-label fw-semibold">Description</label>
          <textarea name="description" id="description" class="form-control" rows="4" required>{{ $submission->description }}</textarea>
        </div>

        <div class="mb-3">
          <label for="CategoryID" class="form-label fw-semibold">Category</label>
          <select name="CategoryID" id="CategoryID" class="form-select" required>
            <option value="" disabled>Select a category</option>
            @foreach ($categories as $category)
              <option value="{{ $category->CategoryID }}" {{ $submission->CategoryID == $category->CategoryID ? 'selected' : '' }}>
                {{ $category->categoryname }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="PriorityID" class="form-label fw-semibold">Priority Level</label>
          <select name="PriorityID" id="PriorityID" class="form-select" required>
            <option value="" disabled>Select priority</option>
            @foreach ($priorities as $priority)
              <option value="{{ $priority->PriorityID }}" {{ $submission->PriorityID == $priority->PriorityID ? 'selected' : '' }}>
                {{ $priority->priorityname }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="d-flex justify-content-end">
          <a href="{{ route('customer.dashboard') }}" class="btn btn-secondary me-2">Cancel</a>
          <button type="submit" class="btn btn-success px-4">Update Submission</button>
        </div>
      </form>
    </div>
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
          crossorigin="anonymous">
  </script>
</body>
</html>
