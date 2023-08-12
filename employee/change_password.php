<?php
session_start();
require_once('config.php');

// Check if the user is not logged in, redirect to employee_login.php
if (!isset($_SESSION['employee_id'])) {
    header('Location: employee_login.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the employee's current password from the database
    $employee_id = $_SESSION['employee_id'];
    $stmt = $conn->prepare("SELECT employees.password FROM employees WHERE id = ? AND employees.password = ?");
    $stmt->bind_param("is", $employee_id, $current_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Verify the new password and confirm password match
        if ($new_password === $confirm_password) {
            // Update the employee's password in the database
            $stmt = $conn->prepare("UPDATE employees SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $new_password, $employee_id);
            $stmt->execute();

            // Set a success message
            $_SESSION['success_message'] = "Password changed successfully!";
            header('Location: employee_dashboard.php');
            exit();
        } else {
            $error_message = "New password and confirm password do not match!";
        }
    } else {
        $error_message = "Invalid current password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Change Password</h4>
                        <?php if (isset($error_message)) { ?>
                        <div class="alert alert-danger"><?= $error_message ?></div>
                        <?php } ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                            <a href="employee_dashboard.php" class="btn-back btn-secondary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>