<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connect.php';

    $warden_id = trim($_POST['warden_id']);
    $name = trim($_POST['warden_name']);
    $phone = trim($_POST['phone_no']);
    $gender = trim($_POST['gender']);

    // Validate all fields filled
    if (empty($warden_id) || empty($name) || empty($phone) || empty($gender)) {
        $message = "<span style='color: red;'>⚠️ All fields are required.</span>";
    }
    // Validate phone number format
    elseif (!preg_match('/^07\d{8}$/', $phone)) {
        $message = "<span style='color: red;'>⚠️ Phone number must start with '07' and be exactly 10 digits.</span>";
    } else {
        // Check duplicate warden id
        $check = $conn->query("SELECT 1 FROM WARDEN WHERE Warden_ID = '$warden_id'");
        if ($check && $check->num_rows > 0) {
            $message = "<span style='color: red;'>⚠️ Warden ID <strong>$warden_id</strong> already exists.</span>";
        } else {
            // Insert
            $sql = "INSERT INTO WARDEN (Warden_ID, Warden_Name, Phone_No, Gender)
                    VALUES ('$warden_id', '$name', '$phone', '$gender')";
            if ($conn->query($sql)) {
                $message = "<span style='color: green;'>✅ Warden added successfully.</span>";
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
  <title>Add Warden</title>
  <link rel="stylesheet" href="Warden_style.css">
</head>
<body>
  <h2>Add Warden</h2>

  <?php if (!empty($message)) echo "<p>$message</p>"; ?>

  <form action="add_warden.php" method="post">
    Warden ID: <input type="number" name="warden_id" required><br>
    Warden Name: <input type="text" name="warden_name" required><br>
    Phone No: <input type="text" 
                     name="phone_no" 
                     required 
                     placeholder="07xxxxxxxx" 
                     pattern="07[0-9]{8}" 
                     title="Phone number must start with 07 and contain 10 digits"><br>
    Gender: <input type="text" name="gender" required><br>
    <input type="submit" value="Add Warden">
  </form>

</body>
</html>
