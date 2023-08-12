<?php
// delete_employee.php

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
  $employee_id = $_GET['id'];

  // Include the database configuration file
  require_once 'config.php';

  // Establish database connection
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Check for foreign key relationships and delete related records from other tables first
  $related_tables = array('deductions', 'income', 'leaves', 'overtime_bonus'); // Replace 'table1', 'table2', etc. with actual table names
  foreach ($related_tables as $table_name) {
    $sql = "DELETE FROM $table_name WHERE employee_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);

    if (!$stmt->execute()) {
      echo "Error deleting related records from $table_name: " . $conn->error;
      $stmt->close();
      $conn->close();
      exit;
    }

    $stmt->close();
  }

  // Delete the employee from the 'employees' table
  $sql = "DELETE FROM employees WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $employee_id);

  if ($stmt->execute()) {
    // Redirect back to admin_dashboard.php after successful deletion
    header('Location: employee_management.php');
    exit;
  } else {
    echo "Error deleting employee: " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}