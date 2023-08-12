<!-- update_employee.php -->
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Process the form submission and update the employee data

  $employee_id = $_POST['employee_id'];
  $name = $_POST['name'];
  $department = $_POST['department'];
  $employee_type = $_POST['employee_type'];
  $basic_pay = $_POST['basic_pay'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
  $home_address = $_POST['home_address'];
  $city = $_POST['city'];
  $zip = $_POST['zip'];
  $marital_status = $_POST['marital_status'];

  require_once 'config.php';

  $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $updateSql = "UPDATE employees SET name = ?, department = ?, employee_type = ?, basic_pay = ?, contact = ?, email = ?, home_address = ?, city = ?, zip = ?, marital_status = ? WHERE id = ?";
  $updateStmt = $conn->prepare($updateSql);
  $updateStmt->bind_param("ssssssssssi", $name, $department, $employee_type, $basic_pay, $contact, $email, $home_address, $city, $zip, $marital_status, $employee_id);

  if ($updateStmt->execute()) {
    $_SESSION['success_message'] = "Employee details updated successfully.";
  } else {
    $_SESSION['error_message'] = "Error updating employee details: " . $conn->error;
  }

  $updateStmt->close();
  $conn->close();

  header("Location: employee_management.php");
  exit;
} else {
  $_SESSION['error_message'] = "Invalid request.";
  header("Location: employee_management.php");
  exit;
}