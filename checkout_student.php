<?php
include 'connect.php';
$message = "";

// Fetch student list
$students = [];
$result = $conn->query("SELECT Student_ID, Name, Room_No FROM STUDENT");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

// Handle form submission only if confirmed via hidden input
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    $student_id = $_POST['student_id'];

    // Get the student's room before deletion
    $room_query = $conn->query("SELECT Room_No FROM STUDENT WHERE Student_ID = '$student_id'");
    if ($room_query && $room_query->num_rows > 0) {
        $room = $room_query->fetch_assoc()['Room_No'];

        // Delete student
        $delete = $conn->query("DELETE FROM STUDENT WHERE Student_ID = '$student_id'");
        if ($delete) {
            // Reduce occupied_count only if student had a room
            if (!empty($room)) {
                $conn->query("UPDATE ROOM SET Occupied_Count = Occupied_Count - 1 WHERE Room_No = '$room'");
            }

            $message = "<span style='color: green;'>✅ Student checked out and removed successfully.</span>";
        } else {
            $message = "<span style='color: red;'>❌ Error: " . $conn->error . "</span>";
        }
    } else {
        $message = "<span style='color: red;'>⚠️ Student ID not found.</span>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Check-Out</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            padding: 30px;
            max-width: 600px;
            margin: 50px auto;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px #ccc;
            border-radius: 10px;
        }
        select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 15px 0;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #007BFF;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        p { font-weight: bold; text-align: center; }

        /* Modal styles */
        #confirmModal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 9999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        #confirmModal .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 0 10px #0003;
            text-align: center;
            font-size: 16px;
        }
        #confirmModal button {
            margin: 10px;
            padding: 8px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }
        #confirmModal button.confirm {
            background-color: #007BFF;
            color: white;
        }
        #confirmModal button.cancel {
            background-color: #ccc;
            color: black;
        }
        #confirmModal button.confirm:hover {
            background-color: #0056b3;
        }
        #confirmModal button.cancel:hover {
            background-color: #aaa;
        }
    </style>
</head>
<body>
    <h2>Student Check-Out</h2>
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <form id="checkoutForm" method="post" onsubmit="return showConfirmModal(event);">
        <label for="student_id">Select Student:</label>
        <select name="student_id" id="student_id" required>
            <option value="">-- Select Student --</option>
            <?php foreach ($students as $s): ?>
                <option value="<?= htmlspecialchars($s['Student_ID']) ?>">
                    <?= htmlspecialchars($s['Student_ID']) ?> - <?= htmlspecialchars($s['Name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <!-- Hidden input to indicate confirmation -->
        <input type="hidden" name="confirm" id="confirmInput" value="no">

        <input type="submit" value="Check-Out Student">
    </form>

    <!-- Confirmation Modal -->
    <div id="confirmModal">
        <div class="modal-content">
            <p>Are you sure you want to check out and delete this student? This action cannot be undone.</p>
            <button class="confirm" onclick="confirmCheckOut()">Yes, Check-Out</button>
            <button class="cancel" onclick="cancelCheckOut()">Cancel</button>
        </div>
    </div>

    <script>
        function showConfirmModal(event) {
            event.preventDefault(); // Prevent form submit
            const studentSelect = document.getElementById('student_id');
            if (!studentSelect.value) {
                alert('Please select a student.');
                return false;
            }
            document.getElementById('confirmModal').style.display = 'block';
            return false; // Don't submit yet
        }

        function confirmCheckOut() {
            document.getElementById('confirmInput').value = 'yes';
            document.getElementById('confirmModal').style.display = 'none';
            document.getElementById('checkoutForm').submit();
        }

        function cancelCheckOut() {
            document.getElementById('confirmModal').style.display = 'none';
        }
    </script>
</body>
</html>
