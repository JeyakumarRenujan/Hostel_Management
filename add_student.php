<?php
$message = "";
$available_rooms = [];

include 'connect.php';

// Step 1: Get already assigned rooms
$assigned_rooms_result = $conn->query("SELECT Room_No FROM STUDENT WHERE Room_No IS NOT NULL");
$assigned_rooms = [];
if ($assigned_rooms_result) {
    while ($row = $assigned_rooms_result->fetch_assoc()) {
        $assigned_rooms[] = $row['Room_No'];
    }
}

// Step 2: Get all room numbers and filter unassigned ones
$rooms_result = $conn->query("SELECT Room_No FROM ROOM");
if ($rooms_result) {
    while ($row = $rooms_result->fetch_assoc()) {
        if (!in_array($row['Room_No'], $assigned_rooms)) {
            $available_rooms[] = $row['Room_No'];
        }
    }
}

// Step 3: Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = trim($_POST['student_id']);
    $name = trim($_POST['name']);
    $gender = trim($_POST['gender']);
    $dob = trim($_POST['dob']);
    $contact = trim($_POST['contact']);
    $room_no = trim($_POST['room_no']);

    // Validation
    if (
        empty($student_id) || empty($name) ||
        empty($gender) || empty($dob) ||
        empty($contact) || empty($room_no)
    ) {
        $message = "<span style='color: red;'>⚠️ All fields including Room No must be filled.</span>";
    } elseif (!preg_match('/^07\d{8}$/', $contact)) {
        $message = "<span style='color: red;'>⚠️ Contact number must be exactly 10 digits and start with '07'.</span>";
    } else {
        // Check for duplicate Student ID
        $check = $conn->query("SELECT 1 FROM STUDENT WHERE Student_ID = '$student_id'");
        if ($check && $check->num_rows > 0) {
            $message = "<span style='color: red;'>⚠️ Student ID <strong>$student_id</strong> already exists.</span>";
        } else {
            // Insert student
            $sql = "INSERT INTO STUDENT (Student_ID, Name, Gender, DOB, Contact, Room_No)
                    VALUES ('$student_id', '$name', '$gender', '$dob', '$contact', '$room_no')";

            if ($conn->query($sql)) {
                // Update room occupied count
                $update_room = "UPDATE ROOM SET Occupied_Count = Occupied_Count + 1 WHERE Room_No = '$room_no'";
                $conn->query($update_room);

                $message = "<span style='color: green;'>✅ Student added successfully.</span>";
            } else {
                $message = "<span style='color: red;'>❌ Error: " . $conn->error . "</span>";
            }
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Student</title>
  <link rel="stylesheet" href="Student_style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;                  
    }
    input, select {
      margin-bottom: 10px;
      padding: 5px;
      width: 250px;
    }
    input[type="submit"] {
      width: 100%;
      cursor: pointer;
      background-color: #007BFF;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 5px;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }
    input[type="submit"]:hover {
      background-color: #0056b3;
    }
    p {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <h2>Add Student</h2>

  <?php if (!empty($message)) echo "<p>$message</p>"; ?>

  <form action="add_student.php" method="post">
    Student ID: <input type="number" name="student_id" required><br>
    Name: <input type="text" name="name" required><br>
    Gender: <input type="text" name="gender" required><br>
    DOB: <input type="date" name="dob" required><br>
    Contact: <input type="text"
                    name="contact"
                    pattern="07[0-9]{8}"
                    title="Contact must be 10 digits starting with 07"
                    placeholder="07xxxxxxxx"
                    required><br>

    Room No:
    <select name="room_no" required>
      <option value="">--Select Room--</option>
      <?php foreach ($available_rooms as $room): ?>
        <option value="<?= htmlspecialchars($room) ?>"><?= htmlspecialchars($room) ?></option>
      <?php endforeach; ?>
    </select><br>

    <input type="submit" value="Add Student">
  </form>
</body>
</html>
