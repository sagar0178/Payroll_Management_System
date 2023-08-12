<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in and if it's not the first time
if (!isset($_SESSION['employee_id']) || $_SESSION['login_option'] !== 'not_first_time') {
    header("Location: employee_login.php");
    exit();
}

// Include the database configuration file
require_once 'config.php';

// Check if the login form is submitted
if (isset($_POST['login_submit'])) {
    // Get the password entered by the user
    $password = $_POST['password'];

    // Get the employee ID from the session
    $employeeId = $_SESSION['employee_id'];

    // Establish database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the entered password matches the password in the employees table
    $query = "SELECT * FROM employees WHERE id = $employeeId AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Password is correct, redirect to the employee dashboard
        header("Location: employee_dashboard.php");
        exit();
    } else {
        // Password is incorrect
        $error_message = "Invalid password. Please try again.";
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
                        <!-- Display error message if password is incorrect -->
                        <?php if (isset($error_message)) : ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
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