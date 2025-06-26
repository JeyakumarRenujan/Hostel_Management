<?php
$message = "";
$students = [];

include 'connect.php';

// Fetch all Student IDs and Names
$student_result = $conn->query("SELECT Student_ID, Name FROM STUDENT");
if ($student_result) {
    while ($row = $student_result->fetch_assoc()) {
        $students[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_id = trim($_POST['payment_id']);
    $student_id = trim($_POST['student_id']);
    $amount = trim($_POST['amount']);
    $date = trim($_POST['payment_date']);

    // Basic validation
    if (empty($payment_id) || empty($student_id) || empty($amount) || empty($date)) {
        $message = "<span style='color: red;'>⚠️ All fields must be filled.</span>";
    } else {
        // Check for duplicate Payment ID
        $check_payment = $conn->query("SELECT 1 FROM PAYMENT WHERE Payment_ID = '$payment_id'");
        if ($check_payment && $check_payment->num_rows > 0) {
            $message = "<span style='color: red;'>⚠️ Payment ID <strong>$payment_id</strong> already exists.</span>";
        }
        // Check if Student ID is valid
        else {
            $check_student = $conn->query("SELECT 1 FROM STUDENT WHERE Student_ID = '$student_id'");
            if (!$check_student || $check_student->num_rows === 0) {
                $message = "<span style='color: red;'>⚠️ Student ID <strong>$student_id</strong> does not exist.</span>";
            } else {
                // Insert the payment
                $sql = "INSERT INTO PAYMENT (Payment_ID, Student_ID, Amount, Payment_Date)
                        VALUES ('$payment_id', '$student_id', '$amount', '$date')";
                if ($conn->query($sql)) {
                    $message = "<span style='color: green;'>✅ Payment added successfully.</span>";
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
  <title>Add Payment</title>
  <link rel="stylesheet" href="Payment_style.css">
</head>
<body>
  <h2>Add Payment</h2>

  <?php if (!empty($message)) echo "<p>$message</p>"; ?>

  <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
    Payment ID: <input type="number" name="payment_id" required><br>

    Student ID:
    <select name="student_id" required>
      <option value="">--Select Student--</option>
      <?php foreach ($students as $student): ?>
        <option value="<?= $student['Student_ID'] ?>">
          <?= $student['Student_ID'] ?> - <?= htmlspecialchars($student['Name']) ?>
        </option>
      <?php endforeach; ?>
    </select><br>

    Amount: <input type="number" step="0.01" name="amount" required><br>
    Payment Date: <input type="date" name="payment_date" required><br>
    <input type="submit" value="Add Payment">
  </form>
</body>
</html>
