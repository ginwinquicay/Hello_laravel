<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Support Staff</title>
</head>
    <h1>Add Staff</h1>
<body>
    <form action="{{url('/staff/create')}}"method="POST">
        @csrf
        <input type="text" name="Fname" placeholder="First Name" required>
        <input type="text" name="Lname" placeholder="Last Name" required>
        <input type="text" name="address" placeholder="Address"  required>
        <input type="text" name="contact_no" placeholder="Mobile Number" required>
        <input type="text" name="email" placeholder="Email" required>
        <input type="text" name="position" placeholder="Position" required>
        <button type="submit" style="cursor: pointer">Create Account</button>
    </form>
    <br><a href="{{url('/staff')}}" method="get">
        <button type="submit" style="cursor: pointer">Return</button></a>
</body>
</html>