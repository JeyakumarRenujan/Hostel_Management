<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit();
}

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $complaint_id = $_POST['complaint_id'] ?? '';
    $status = $_POST['status'] ?? '';

    // Basic validation
    $valid_statuses = ['Pending', 'In Progress', 'Resolved'];
    if (in_array($status, $valid_statuses) && !empty($complaint_id)) {
        $stmt = $conn->prepare("UPDATE COMPLAINT SET Status = ? WHERE Complaint_ID = ?");
        $stmt->bind_param("si", $status, $complaint_id);

        if ($stmt->execute()) {
            // Success: Redirect back with success message (optional)
            header("Location: view_complaints.php?msg=Status updated successfully");
            exit();
        } else {
            echo "Error updating status: " . $conn->error;
        }
    } else {
        echo "Invalid status or complaint ID.";
    }
} else {
    // If accessed directly without POST
    header("Location: view_complaints.php");
    exit();
}
?>
