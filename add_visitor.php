<?php
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    $visitor_id = trim($_POST['visitor_id']);
    $student_id = trim($_POST['student_id']);
    $name = trim($_POST['visitor_name']);
    $date = trim($_POST['visit_date']);
    $purpose = trim($_POST['purpose']);

    // Check for empty fields
    if (empty($visitor_id) || empty($student_id) || empty($name) || empty($date) || empty($purpose)) {
        $message = "<span style='color: red;'>⚠️ All fields must be filled.</span>";
    } else {
        // Check if Student_ID exists in STUDENT table
        $student_check = $conn->query("SELECT 1 FROM STUDENT WHERE Student_ID = '$student_id'");
        if (!$student_check || $student_check->num_rows == 0) {
            $message = "<span style='color: red;'>⚠️ Student ID <strong>$student_id</strong> does not exist. Please enter a valid Student ID.</span>";
        } else {
            // Check for duplicate Visitor_ID
            $visitor_check = $conn->query("SELECT 1 FROM VISITOR WHERE Visitor_ID = '$visitor_id'");
            if ($visitor_check && $visitor_check->num_rows > 0) {
                $message = "<span style='color: red;'>⚠️ Visitor ID <strong>$visitor_id</strong> already exists. Please use a different ID.</span>";
            } else {
                // Insert visitor log
                $sql = "INSERT INTO VISITOR (Visitor_ID, Student_ID, Visitor_Name, Visit_Date, Purpose)
                        VALUES ('$visitor_id', '$student_id', '$name', '$date', '$purpose')";

                if ($conn->query($sql)) {
                    $message = "<span style='color: green;'>✅ Visitor log added successfully.</span>";
                } else {
                    $message = "<span style='color: red;'>❌ Error: " . $conn->error . "</span>";
                }
            }
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Visitor</title>
  <link rel="stylesheet" href="Visitor_style.css">
</head>
<body>
  <h2>Add Visitor Log</h2>

  <?php if (!empty($message)) echo "<p>$message</p>"; ?>

  <form action="add_visitor.php" method="post">
    Visitor ID: <input type="number" name="visitor_id" required><br>
    Student ID: <input type="number" name="student_id" required><br>
    Visitor Name: <input type="text" name="visitor_name" required><br>
    Visit Date: <input type="date" name="visit_date" required><br>
    Purpose: <input type="text" name="purpose" required><br>
    <input type="submit" value="Add Visitor">
  </form>

</body>
</html>
