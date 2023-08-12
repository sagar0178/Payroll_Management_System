<?php
// Start the session to access session variables
session_start();

// Check if the user is not logged in, redirect to employee_login.php
if (!isset($_SESSION['employee_id'])) {
    header('Location: employee_login.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include database configuration
    require_once 'config.php';

    // Get employee_id from the session
    $employee_id = $_SESSION['employee_id'];

    // Get leave application data from the form
    $leave_reason = $_POST['leave_reason'];
    $address = $_POST['address'];
    $leave_type = $_POST['leave_type'];
    $leave_status = ''; // Set the leave status to 'blank' by default

    // Prepare and execute the SQL query to insert leave application data into the leaves table
    $stmt = $conn->prepare("INSERT INTO leaves (employee_id, leave_reason, address, leave_type, leave_status) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error: " . $conn->error); // Output the error message for debugging
    }

    $stmt->bind_param("issss", $employee_id, $leave_reason, $address, $leave_type, $leave_status);

    if ($stmt->execute()) {
        // Leave application added successfully
        $_SESSION['success_message'] = "Leave application submitted successfully!";
        header("Location: apply_leave.php");
        exit();
    } else {
        // Error occurred while adding leave application
        $_SESSION['error_message'] = "Error submitting leave application. Please try again.";
        header("Location: apply_leave.php");
        exit();
    }
} else {
    // If the form is not submitted, redirect to apply_leave.php
    header("Location: apply_leave.php");
    exit();
}