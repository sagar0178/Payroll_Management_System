<?php
// Start the session to access session variables
session_start();

// Check if the user is not logged in, redirect to employee_login.php
if (!isset($_SESSION['employee_id'])) {
    header('Location: employee_login.php');
    exit();
}

// Include the database configuration file
require_once 'config.php';

// Fetch the logged-in employee's ID
$employee_id = $_SESSION['employee_id'];

// Check if there is a success message from cancel_leave.php
$success_message = "";
if (isset($_GET['success']) && $_GET['success'] === 'cancel') {
    $success_message = "Leave application has been canceled successfully.";
}

// Check if there is an error message from cancel_leave.php
$error_message = "";
if (isset($_GET['error']) && $_GET['error'] === 'cancel') {
    $error_message = "Failed to cancel the leave application.";
}

// Fetch the leave applications of the logged-in employee
$stmt = $conn->prepare("SELECT leaves.id, employees.name, leaves.leave_reason, leaves.address, leaves.leave_type, leaves.leave_status FROM leaves JOIN employees ON leaves.employee_id = employees.id WHERE leaves.employee_id = ?");
$stmt->bind_param('i', $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Leave Applications</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">View Leave Applications</h4>
                        <?php if (!empty($success_message) || !empty($error_message)) { ?>
                        <div
                            class="alert alert-dismissible <?= !empty($success_message) ? 'alert-success' : 'alert-danger' ?>">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?= !empty($success_message) ? $success_message : $error_message ?>
                        </div>
                        <?php } ?>
                        <script>
                        // Auto-hide the alert after 5 seconds
                        setTimeout(function() {
                            document.querySelector('.alert').style.display = 'none';
                        }, 3000);
                        </script>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Leave ID</th>
                                        <th>Name</th>
                                        <th>Reason</th>
                                        <th>Address</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['leave_reason'] ?></td>
                                        <td><?= $row['address'] ?></td>
                                        <td><?= $row['leave_type'] ?></td>
                                        <td><?= $row['leave_status'] ?></td>
                                        <td>
                                            <?php if ($row['leave_status'] === 'pending') { ?>
                                            <a href="cancel_leave.php?id=<?= $row['id']; ?>"
                                                class="btn btn-danger btn-sm">Cancel Leave</a>
                                            <?php } else { ?>
                                            <button class="btn btn-danger btn-sm" disabled>Cancel Leave</button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <a href="employee_dashboard.php" class="btn btn-secondary btn-sm float-right">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>