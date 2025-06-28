<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit();
}
include 'connect.php';

$result = $conn->query("SELECT * FROM COMPLAINT ORDER BY Complaint_Date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Complaints</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            margin: 20px;
            color: #333;
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }
        th {
            background-color: #007BFF;
            color: white;
            font-weight: 600;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        form {
            margin: 0;
        }
        select {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 6px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        @media (max-width: 700px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            tr {
                margin-bottom: 15px;
                border-bottom: 2px solid #ddd;
            }
            th {
                background-color: transparent;
                color: #333;
                font-weight: bold;
                padding-top: 10px;
            }
            td {
                padding-left: 50%;
                position: relative;
            }
            td::before {
                position: absolute;
                left: 15px;
                top: 12px;
                white-space: nowrap;
                font-weight: bold;
                content: attr(data-label);
            }
        }
        .message {
            width: 90%;
            margin: 0 auto 20px auto;
            padding: 10px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Complaints</h2>

    <?php if (isset($_GET['msg'])): ?>
        <div class="message"><?php echo htmlspecialchars($_GET['msg']); ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Complaint ID</th>
                <th>Student ID</th>
                <th>Complaint Text</th>
                <th>Complaint Date</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td data-label="Complaint ID"><?php echo htmlspecialchars($row['Complaint_ID']); ?></td>
                <td data-label="Student ID"><?php echo htmlspecialchars($row['Student_ID']); ?></td>
                <td data-label="Complaint"><?php echo htmlspecialchars($row['Complaint_Text']); ?></td>
                <td data-label="Complaint Date"><?php echo htmlspecialchars($row['Complaint_Date']); ?></td>
                <td data-label="Status"><?php echo htmlspecialchars($row['Status']); ?></td>
                <td data-label="Update Status">
                    <form method="post" action="update_status.php">
                        <select name="status" required>
                            <option value="Pending" <?php if($row['Status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="In Progress" <?php if($row['Status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                            <option value="Resolved" <?php if($row['Status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
                        </select>
                        <input type="hidden" name="complaint_id" value="<?php echo htmlspecialchars($row['Complaint_ID']); ?>">
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
