<?php
// Start the session to access session variables
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <!-- Sidebar -->
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link">Update Tax-OT-Bonus</a>
                        </li>
                        <li class="nav-item">
                            <a href="employee_management.php" class="nav-link active">Employee Management</a>
                        </li>
                        <li class="nav-item">
                            <a href="add_employee.php" class="nav-link">Add New Employee Details</a>
                        </li>
                        <li class="nav-item">
                            <a href="add_department.php" class="nav-link">Add New Department</a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a href="add_overtime_bonus.php" class="nav-link">Add Overtime/Bonuses</a>
                        </li>
                        <li class="nav-item">
                            <a href="delete_password.php" class="nav-link">Delete Password</a>
                        </li>
                    </ul>
                </div>
            </nav>
            </main>
        </div>
    </div>

    <!-- Link Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Link Custom JS -->
    <script src="script.js"></script>
</body>

</html>