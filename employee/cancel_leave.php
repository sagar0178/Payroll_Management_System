<?php
// Include the database configuration file
require_once 'config.php';

// Check if the user is not logged in, redirect to employee_login.php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header('Location: employee_login.php');
    exit();
}

// Check if the leave id is provided in the URL
if (isset($_GET['id'])) {
    $leave_id = $_GET['id'];

    // Check if the leave exists and belongs to the logged-in employee
    $employee_id = $_SESSION['employee_id'];
    $stmt = $conn->prepare("SELECT leave_status FROM leaves WHERE id = ? AND employee_id = ?");
    $stmt->bind_param('ii', $leave_id, $employee_id);
    $stmt->execute();
    $stmt->bind_result($leave_status);
    $stmt->fetch();
    $stmt->close();

    // Check if the leave is pending and belongs to the employee
    if ($leave_status === 'pending') {
        // Delete the leave application
        $stmt = $conn->prepare("DELETE FROM leaves WHERE id = ? AND employee_id = ?");
        $stmt->bind_param('ii', $leave_id, $employee_id);
        if ($stmt->execute()) {
            // Redirect back to the view_leave.php page with success message
            header('Location: view_leave.php?success=cancel');
            exit();
        } else {
            // Redirect back to the view_leave.php page with error message
            header('Location: view_leave.php?error=cancel');
            exit();
        }
    } else {
        // Redirect back to the view_leave.php page with error message
        header('Location: view_leave.php?error=cancel');
        exit();
    }
} else {
    // Redirect back to the view_leave.php page with error message
    header('Location: view_leave.php?error=cancel');
    exit();
}