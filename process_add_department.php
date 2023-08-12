<?php
// Include the database configuration file
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $department = $_POST['department'];

    // Establish database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert new department data into the database
    $sql = "INSERT INTO departments (department_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $department);

    if ($stmt->execute()) {
        // Success: Redirect back to the admin dashboard with a success message
        session_start();
        $_SESSION['success_message'] = "Department added successfully!";
        header('Location: admin_dashboard.php');
        exit;
    } else {
        // Error: Redirect back to the add department page with an error message
        header('Location: add_department.php?error=1');
        exit;
    }

    $stmt->close();
    $conn->close();
}