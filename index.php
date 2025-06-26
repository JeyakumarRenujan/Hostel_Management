<!DOCTYPE html>
<html>
<head>
    <title>Hostel Management System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="sidebar.css">
    <style>
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 200px;
            background-color: #2c3e50;
            padding: 20px;
            height: 100vh;
            color: white;
        }

        .sidebar h3 {
            margin-top: 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }

        .sidebar a:hover {
            text-decoration: none;
        }

        .main-content {
            flex-grow: 1;
            padding: 0;
        }

        iframe {
            width: 100%;
            height: 100vh;
            border: none;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>🏠 Hostel Menu</h3>
        <a href="add_student.php" target="mainframe">Add Student</a>
        <a href="add_room.php" target="mainframe">Add Room</a>
        <a href="add_warden.php" target="mainframe">Add Warden</a>
        <a href="add_payment.php" target="mainframe">Add Payment</a>
        <a href="add_visitor.php" target="mainframe">Add Visitor</a>
        <a href="add_complaint.php" target="mainframe">Add Complaint</a>
        <a href="checkout_student.php" target="mainframe">Student Check-Out</a> 
    </div>

    <div class="main-content">
        <iframe name="mainframe" src="welcome.php"></iframe>
    </div>
</body>
</html>
