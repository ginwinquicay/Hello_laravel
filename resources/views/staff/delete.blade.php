<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete Account</title>
    <style>
        .D{
            padding: 5px;
            margin: 0;
        }
        
    </style>
</head>
<h1 class="D">Delete Account?</h1>
<body>
    Are you sure you want to DELETE <span style="color:red">"{{$EditStaff[0]->Fname}} {{$EditStaff[0]->Lname}}"</span> account?
    <a href="{{url('/staff/'.$EditStaff[0]->StaffID.'/destroy')}}"method="get"><button style="cursor: pointer">YES</button></a>
    <a href="{{url('/staff')}}"><button style="cursor: pointer">NO</button></a>
</body>
</html>