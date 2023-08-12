<?php
// Start the session to access session variables
session_start();

// Include the database configuration file
require_once '../config.php';

// Check if the create password form is submitted
if (isset($_POST['create_password_submit'])) {
    // Get the entered password and confirm password from the form
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate the password and confirm password
    if ($password !== $confirmPassword) {
        $_SESSION['password_error'] = "Passwords do not match. Please try again.";
        header("Location: create_password.php");
        exit();
    }

    // Get the email from the URL parameter
    $email = $_GET['email'];

    // Encrypt the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Include the database configuration file
    require_once '../config.php';

    // Establish database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the password in the employees table
    $sql = "UPDATE employees SET password = '$hashedPassword' WHERE email = '$email'";
    if ($conn->query($sql) === TRUE) {
        // Password updated successfully
        $_SESSION['password_success'] = "Password created successfully. You can now login.";
        header("Location: employee_login.php");
        exit();
    } else {
        // Error updating password
        $_SESSION['password_error'] = "Error creating password. Please try again.";
        header("Location: create_password.php?email=$email");
        exit();
    }

    // Close the database connection
    $conn->close();
} else {
    // If the form is not submitted, redirect to the create password page
    header("Location: create_password.php");
    exit();
}