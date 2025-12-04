<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Staff Accounts</title>
</head>
    <h1>Edit Accounts</h1>
<body>
    <form action="{{url('/staff/'.$EditStaff[0]->StaffID.'/update')}}"method ="POST">
        @csrf
        <input type="text" name="Fname" id="" value="{{$EditStaff[0]->Fname}}" required>
        <input type="text" name="Lname" id="" value="{{$EditStaff[0]->Lname}}" required>
        <input type="text" name="address" id="" value="{{$EditStaff[0]->address}}" required>
        <input type="text" name="contact_no" id="" value="{{$EditStaff[0]->contact_no}}"required>
        <input type="text" name="email" id="" value="{{$EditStaff[0]->email}}"required>
        <input type="text" name="position" id="" value="{{$EditStaff[0]->position}}" required>
        <button type="submit" style="cursor: pointer">Save</button>
    </form>
    <br>
    <a href="{{url('/staff')}}"method="get">
    <button style="cursor: pointer">Return</button></a>
</body>
</html>