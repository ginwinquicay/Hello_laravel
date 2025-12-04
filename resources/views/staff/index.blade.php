<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff</title>
    <style>
        .S{
            padding: 5px;
            margin: 0
        }
        .stafftable td{
            padding: 5px;
        }
        .stafftable th{
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<h1 class="S">Staff List</h1>
<body>
    @if (empty($staffList))
        There are no STAFF data
    @else
        <table class="stafftable">
            <thead>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Position</th>
            </thead>
            <tbody>
                @foreach($staffList as $staff)
                    <tr>
                        <td>{{$staff->StaffID}}</td>
                        <td>{{$staff->Fname}}</td>
                        <td>{{$staff->Lname}}</td>
                        <td>{{$staff->address}}</td>
                        <td>{{$staff->contact_no}}</td>
                        <td>{{$staff->email}}</td>
                        <td>{{$staff->position}}</td>
                        <td><a href="{{url('/staff/'.$staff->StaffID.'/edit')}}"method="get">
                        <button type="submit"style="cursor: pointer">Edit</button></a><td>
                        <td><a href="{{url('/staff/'.$staff->StaffID.'/delete')}}"method="get">
                        <button style="cursor: pointer">Delete</button></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <br>
    <a href="{{url('/staff/add')}}"method="get">
        <button type="submit" style="cursor: pointer">Add Staff Account</button></a>
</body>
</html>