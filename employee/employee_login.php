<?php
// Start the session to access session variables
session_start();

// Include the database configuration file
require_once 'config.php';

// Check if the user is already logged in
if (isset($_SESSION['employee_id'])) {
    header("Location: employee_dashboard.php");
    exit();
}

// Check if the login form is submitted
if (isset($_POST['login_submit'])) {
    // Get the email entered by the user
    $email = $_POST['email'];

    // Check the option selected by the user (First Time or Not First Time)
    $loginOption = $_POST['login_option'];

    // Establish database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user exists in the employees table
    $query = "SELECT * FROM employees WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // User exists
        $row = $result->fetch_assoc();
        $employeeId = $row['id'];

        // Check if the password column is empty
        $password = $row['password'];

        if ($loginOption === 'first_time' && empty($password)) {
            // If it's the first time and password is empty, set the session variables and redirect to the create_password page
            $_SESSION['employee_id'] = $employeeId;
            $_SESSION['login_option'] = 'first_time';
            header("Location: create_password.php");
            exit();
        } elseif ($loginOption === 'not_first_time' && !empty($password)) {
            // If it's not the first time and password is not empty, set the session variables and redirect to the employee_login_form page
            $_SESSION['employee_id'] = $employeeId;
            $_SESSION['login_option'] = 'not_first_time';
            header("Location: employee_login_form.php");
            exit();
        } else {
            // If the selected option does not match the current password status, display an error message
            $error_message = "Invalid login option. Please try again.";
        }
    } else {
        // User does not exist
        $error_message = "Employee does not exist. Please enter a valid email.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Employee Login
                    </div>
                    <div class="card-body">
                        <!-- Display error message if exists -->
                        <?php if (isset($error_message)) : ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="login_option">Login Option</label>
                                <select class="form-control" id="login_option" name="login_option" required>
                                    <option value="first_time">First Time</option>
                                    <option value="not_first_time">Not First Time</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="login_submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>