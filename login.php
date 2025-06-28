<?php
session_start();
include 'connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check credentials in USER_LOGIN only
    $stmt = $conn->prepare("SELECT * FROM USER_LOGIN WHERE Username = ? AND Password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['Username'];
        $_SESSION['role'] = $user['Role'];

        if ($user['Role'] == 'student') {
            header("Location: student_dashboard.php");
            exit();
        } else {
            header("Location: staff_dashboard.php");
            exit();
        }
    } else {
        $message = "<span class='error'>Invalid login credentials.</span>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Hostel Management System</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 93%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .login-box button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            border: none;
            border-radius: 6px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .login-box button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-weight: bold;
            text-align: center;
            display: block;
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <form method="post" autocomplete="off">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <?php if (!empty($message)) echo "<p>$message</p>"; ?>
        <div class="footer">© 2025 Hostel Management System</div>
    </div>
</body>
</html>
