<?php
// Start the session to access session variables
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $employee_id = $_POST['employee_id'];
  $overtime_hours = $_POST['overtime_hours'];
  $bonus_amount = $_POST['bonus_amount'];

  // Validate and sanitize the input data here if needed

  // Include the database configuration file
  require_once 'config.php';

  // Establish database connection
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Check for connection errors
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Check if the employee already has overtime and bonus records in the database
  $sql = "SELECT * FROM overtime_bonus WHERE employee_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $employee_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Employee has existing overtime and bonus records, update them
    $sql = "UPDATE overtime_bonus SET overtime_hours = ?, bonus_amount = ? WHERE employee_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ddi", $overtime_hours, $bonus_amount, $employee_id);
    $stmt->execute();
  } else {
    // Employee does not have overtime and bonus records, add them
    $sql = "INSERT INTO overtime_bonus (employee_id, overtime_hours, bonus_amount) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idd", $employee_id, $overtime_hours, $bonus_amount);
    $stmt->execute();
  }

  // Close the prepared statement and database connection
  $stmt->close();
  $conn->close();

  // Redirect back to the employee management page with a success message
  $_SESSION['success_message'] = "Overtime and bonus details updated successfully!";
  header("Location: employee_management.php");
  exit;
} else {
  // Invalid request method, redirect back to the employee management page with an error message
  $_SESSION['error_message'] = "Invalid request.";
  header("Location: employee_management.php");
  exit;
}