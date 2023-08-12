<?php
// Start the session to access session variables
session_start();

// Include the database configuration file
require_once '../config.php';

// Establish database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the login form is submitted
if (isset($_POST['login_submit'])) {
    // Get the entered email from the form
    $email = $_POST['email'];

    // Check if the email exists in the employees table
    $sql = "SELECT * FROM employees WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email exists in the employees table
        $row = $result->fetch_assoc();

        // Check the selected login option
        if (isset($_POST['login_option'])) {
            $loginOption = $_POST['login_option'];

            if ($loginOption === 'first_time') {
                // If first time login, redirect to create password page
                header("Location: create_password.php?email=$email");
                exit();
            } elseif ($loginOption === 'not_first_time') {
                // If not first time login, show the regular login form
                $_SESSION['employee_id'] = $row['id'];
                header("Location: employee_login_form.php");
                exit();
            }
        }
    } else {
        // Email does not exist in the employees table
        $_SESSION['login_error'] = "Invalid email address. Please try again.";
        header("Location: employee_login.php");
        exit();
    }
}

// Close the database connection
$conn->close();