<?php
$message = "";
$wardens = [];

include 'connect.php';

// Fetch all Warden IDs and Names
$warden_result = $conn->query("SELECT Warden_ID, Warden_Name FROM WARDEN");
if ($warden_result) {
    while ($row = $warden_result->fetch_assoc()) {
        $wardens[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_no = trim($_POST['room_no']);
    $room_type = trim($_POST['room_type']);
    $no_of_beds = trim($_POST['no_of_beds']);
    $furniture = trim($_POST['furniture_details']);
    $ac_status = trim($_POST['ac_status']);
    $warden_id = trim($_POST['warden_id']);

    // Validation: All fields required
    if (
        empty($room_no) || empty($room_type) || empty($no_of_beds) ||
        empty($furniture) || empty($ac_status) || empty($warden_id)
    ) {
        $message = "<span style='color:red;'>⚠️ All fields are required.</span>";
    } else {
        // Check for duplicate Room No
        $check = $conn->query("SELECT 1 FROM ROOM WHERE Room_No = '$room_no'");
        if ($check && $check->num_rows > 0) {
            $message = "<span style='color:red;'>⚠️ Room No <strong>$room_no</strong> already exists. Please use a different number.</span>";
        } else {
            // Insert room
            $sql = "INSERT INTO ROOM (Room_No, Room_Type, No_of_Beds, Furniture_Details, AC_Status, Warden_ID)
                    VALUES ('$room_no', '$room_type', '$no_of_beds', '$furniture', '$ac_status', '$warden_id')";

            if ($conn->query($sql)) {
                $message = "<span style='color:green;'>✅ Room added successfully.</span>";
            } else {
                $message = "<span style='color:red;'>❌ Error: " . $conn->error . "</span>";
            }
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Room</title>
  <link rel="stylesheet" href="Room_style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #eef2f3;
      padding: 20px;
      max-width: 600px;
      margin: 40px auto;
    }

    h2 {
      color: #333;
      text-align: center;
      margin-bottom: 25px;
      font-weight: 600;
    }

    form {
      background-color: white;
      padding: 20px 25px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    label, select {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
      color: #555;
    }

    input[type="number"],
    input[type="text"],
    select {
      width: 100%;
      padding: 8px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
      font-size: 14px;
    }

    input[type="submit"] {
      background-color: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
      padding: 12px;
      font-size: 16px;
      border-radius: 5px;
      transition: background-color 0.3s ease;
      width: 100%;
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
  <h2>Add Room</h2>

  <?php if (!empty($message)) echo "<p>$message</p>"; ?>

  <form action="add_room.php" method="post">
    Room No: <input type="number" name="room_no" required><br>

    Room Type:
    <select name="room_type" required>
      <option value="">--Select Room Type--</option>
      <option value="Single">Single</option>
      <option value="Double">Double</option>
    </select><br>

    No of Beds: <input type="number" name="no_of_beds" required><br>
    Furniture Details: <input type="text" name="furniture_details" required><br>

    AC Status:
    <select name="ac_status" required>
        <option value="">--Select AC Status--</option>
        <option value="AC">AC</option>
        <option value="Non-AC">Non-AC</option>
    </select><br>

    Warden ID:
    <select name="warden_id" required>
        <option value="">--Select Warden--</option>
        <?php foreach ($wardens as $warden): ?>
            <option value="<?= $warden['Warden_ID'] ?>">
                <?= $warden['Warden_ID'] ?> - <?= htmlspecialchars($warden['Warden_Name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <input type="submit" value="Add Room">
  </form>
</body>
</html>
