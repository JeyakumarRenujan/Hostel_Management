<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Sanitize and get form data
    $complaint_id = trim($_POST['complaint_id']);
    $student_id = trim($_POST['student_id']);
    $complaint_text = trim($_POST['complaint_text']);
    $complaint_date = trim($_POST['complaint_date']);
    $status = trim($_POST['status']);

    // Validate all fields filled
    if (empty($complaint_id) || empty($student_id) || empty($complaint_text) || empty($complaint_date) || empty($status)) {
        $message = "<span style='color: red;'>⚠️ All fields must be filled.</span>";
    } else {
        // Check if Complaint_ID already exists
        $check_id = $conn->prepare("SELECT 1 FROM COMPLAINT WHERE Complaint_ID = ?");
        $check_id->bind_param("i", $complaint_id);
        $check_id->execute();
        $check_id->store_result();

        if ($check_id->num_rows > 0) {
            $message = "<span style='color: red;'>⚠️ Complaint ID <strong>$complaint_id</strong> already exists. Use a different ID.</span>";
        } else {
            // Check if Student_ID exists in STUDENT table (optional, good to keep)
            $check_student = $conn->prepare("SELECT 1 FROM STUDENT WHERE Student_ID = ?");
            $check_student->bind_param("i", $student_id);
            $check_student->execute();
            $check_student->store_result();

            if ($check_student->num_rows == 0) {
                $message = "<span style='color: red;'>⚠️ Student ID <strong>$student_id</strong> does not exist.</span>";
            } else {
                // Insert new complaint
                $stmt = $conn->prepare("INSERT INTO COMPLAINT (Complaint_ID, Student_ID, Complaint_Text, Complaint_Date, Status) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("iisss", $complaint_id, $student_id, $complaint_text, $complaint_date, $status);

                if ($stmt->execute()) {
                    $message = "<span style='color: green;'>✅ Complaint added successfully.</span>";
                } else {
                    $message = "<span style='color: red;'>❌ Error: " . $conn->error . "</span>";
                }
                $stmt->close();
            }
            $check_student->close();
        }
        $check_id->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Complaint</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 600px;
      margin: 40px auto;
      padding: 20px;
      background: #f9f9f9;
    }
    form {
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }
    input, textarea, select {
      width: 100%;
      padding: 8px;
      margin-bottom: 15px;
      border-radius: 4px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    input[type="submit"] {
      background: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 16px;
    }
    input[type="submit"]:hover {
      background: #0056b3;
    }
    p {
      font-weight: bold;
    }
  </style>
</head>
<body>

  <h2>Add Complaint</h2>

  <?php if (!empty($message)) echo "<p>$message</p>"; ?>

  <form action="add_complaint.php" method="post">
    Complaint ID: <input type="number" name="complaint_id" required><br>
    Student ID: <input type="number" name="student_id" required><br>
    Complaint Text: <textarea name="complaint_text" required></textarea><br>
    Complaint Date: <input type="date" name="complaint_date" required><br>

    Status:
    <select name="status" required>
      <option value="">--Select Status--</option>
      <option value="Pending">Pending</option>
      <option value="Resolved">Resolved</option>
      <option value="Rejected">Rejected</option>
    </select><br>

    <input type="submit" value="Add Complaint">
  </form>

</body>
</html>
