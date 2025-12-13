<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Submission</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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
  --text-prim: #4A70A9;
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

/* CARD */
.card-custom {
  background: white;
  border-radius: var(--radius);
  border: none;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* FORM LABELS */
.form-label {
  font-weight: 600;
}

/* BUTTONS */
.btn-primary {
  background-color: var(--primary-color);
  color: white;
  border-radius: 6px;
  font-weight: 500;
  padding: 8px 20px;
  transition: all 0.3s ease;
}
.btn-primary:hover {
  background-color: var(--hover-accent);
  transform: scale(1.04);
  color: white;
}

.btn-ret {
  background-color: var(--secodary-color);
  border-radius: 6px;
  font-weight: 500;
  color: white;
  padding: 8px 20px;
  transition: all 0.3s ease;
  text-decoration: none;
}
.btn-ret:hover {
  background-color: var(--hover-accent2);
  color: white;
  transform: scale(1.04);
}
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg py-3 px-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ECHOCARE</a>
  </div>
</nav>

<div class="container py-5">
  <div class="card card-custom mx-auto p-4" style="max-width: 700px;">
    <h3 class="text-prim mb-4">Edit Submission</h3>

    <form method="POST" action="{{ route('submission.update', $submission->SubmissionID) }}">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="4" required>{{ $submission->description }}</textarea>
      </div>

      <div class="mb-3">
        <label for="CategoryID" class="form-label">Category</label>
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
        <label for="PriorityID" class="form-label">Priority Level</label>
        <select name="PriorityID" id="PriorityID" class="form-select" required>
          <option value="" disabled>Select priority</option>
          @foreach ($priorities as $priority)
            <option value="{{ $priority->PriorityID }}" {{ $submission->PriorityID == $priority->PriorityID ? 'selected' : '' }}>
              {{ $priority->priorityname }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="d-flex justify-content-end gap-2">
        <a href="{{ url('/customer/dashboard') }}" class="btn btn-ret">Cancel</a>
        <button type="submit" class="btn btn-primary px-4">Update</button>
      </div>

    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
