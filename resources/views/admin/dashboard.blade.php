<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, {{ Auth::guard('admin')->user()->name }}</h1>
    <p>This is your Admin Dashboard.</p>

    <form method="POST" action="{{ route('logout.admin') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
