<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in and if it's the first time
if (!isset($_SESSION['employee_id']) || $_SESSION['login_option'] !== 'first_time') {
    header("Location: employee_login.php");
    exit();
}

// Include the database configuration file
require_once 'config.php';

// Check if the password form is submitted
if (isset($_POST['password_submit'])) {
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

    // Update the password in the employees table
    $query = "UPDATE employees SET password = '$password' WHERE id = $employeeId";
    if ($conn->query($query)) {
        // Password updated successfully
        // Redirect to the employee dashboard
        header("Location: employee_dashboard.php");
        exit();
    } else {
        // Error updating password
        $error_message = "Error updating password. Please try again.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Password</title>
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
                        Create Password
                    </div>
                    <div class="card-body">
                        <!-- Display error message if there was an error updating the password -->
                        <?php if (isset($error_message)) : ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="password_submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>