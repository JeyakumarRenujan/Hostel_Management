<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="sidebar.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-size: cover;
        }

        .main-content {
            margin-left: 240px;
            padding: 0;
            height: 100vh;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>🎓 Student Menu</h3>
        <a href="add_complaint.php" target="mainframe">Add Complaint</a>
        <a href="logout.php" onclick="return confirm('Are you sure you want to logout?');">Logout</a>
    </div>

    <div class="main-content">
        <iframe name="mainframe" src="welcome.php"></iframe>
    </div>
</body>
</html>
