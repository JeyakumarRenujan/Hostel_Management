<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="sidebar.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .content {
            padding: 20px;
            background-color: #f7f9fa;
            min-height: 100vh;
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
        <a href="view_students.php" target="mainframe">View Students</a>
        <a href="view_complaints.php" target="mainframe">View Complaints</a>
        <a href="checkout_student.php" target="mainframe">Student Check-Out</a> 
        <a href="logout.php" onclick="return confirm('Are you sure you want to logout?');">Logout</a>
    </div>

    <div class="main-content">
        <iframe name="mainframe" src="welcome.php" style="width:100%; height:100vh; border:none;"></iframe>
    </div>
</body>
</html>
