<?php
// Include the database configuration file
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
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


    // Establish database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert new employee data into the database
    $sql = "INSERT INTO employees (name, department, employee_type, basic_pay, contact, email, home_address, city, zip, marital_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $name, $department, $employee_type, $basic_pay, $contact, $email, $home_address, $city, $zip, $marital_status);

    if ($stmt->execute()) {
        // Success: Redirect back to the admin dashboard with a success message
        session_start();
        $_SESSION['success_message'] = "Employee added successfully!";
        header('Location: employee_management.php');
        exit;
    } else {
        // Error: Redirect back to the add employee page with an error message
        header('Location: add_employee.php?error=1');
        exit;
    }

    $stmt->close();
    $conn->close();
}