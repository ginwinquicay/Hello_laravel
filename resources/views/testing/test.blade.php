<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EchoCare Services</title>
    <style>
        .main {
    margin: 20px;
    font-family: Arial;
}

.topbar {
    background-color: black;
    margin: 0;
    width: 100%;
    height: 75px;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.bname {
    font-size: 30px;
    color: white;
    padding: 0 30px;
}

.bar {
    margin-right: 30px;
    position: relative;
}

.bar a {
    color: white;
    text-decoration: none;
    font-size: 20px;
    padding: 10px 15px;
    font-weight: bold;
}

.bar a:hover {
    background-color: white;
    color: black;
    border-radius: 5px;
}

/* Dropdown container */
.dropdown {
    display: inline-block;
    position: relative;
}

/* Dropdown content */
.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: white;
    min-width: 140px;
    border-radius: 5px;
    box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
    z-index: 1;
}

/* Links inside dropdown */
.dropdown-content a {
    color: black;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #ddd;
}

/* Show dropdown on hover */
.dropdown:hover .dropdown-content {
    display: block;
}

    </style>
</head>
<body class="main">
    <div class="topbar">
        <div class="bname">
            <strong>EchoCare</strong>
        </div>

        <div class="bar">
            <div class="dropdown">
                <a href="#" class="dropbtn">Log in</a>
                <div class="dropdown-content">
                    <a href="#">Customer</a>
                    <a href="#">Staff</a>
                    <a href="#">Admin</a>
                </div>
            </div>
            <a href="#">Sign up</a>
        </div>
    </div>
</body>
</html>
