<?php
session_start();
require_once('config.php');

// Check if the user is not logged in, redirect to employee_login.php
if (!isset($_SESSION['employee_id'])) {
    header('Location: employee_login.php');
    exit();
}

// Fetch employee details from the database
$employee_id = $_SESSION['employee_id'];
$stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employee Details</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link Custom CSS -->
    <style>
    body {
        padding-top: 20px;
    }

    .card-content {
        padding-top: 20px;
        position: sticky;
    }

    .card-title {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .btn-back {
        position: sticky;
        top: 20px;
        float: right;
        margin-right: 20px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card card-content">
                    <div class="card-body">
                        <h4 class="card-title">View Employee Details</h4>
                        <p><strong>Name:</strong> <?php echo $employee['name']; ?></p>
                        <p><strong>Email:</strong> <?php echo $employee['email']; ?></p>
                        <p><strong>Contact:</strong> <?php echo $employee['contact']; ?></p>
                        <p><strong>Address:</strong> <?php echo $employee['home_address']; ?></p>
                        <p><strong>City:</strong> <?php echo $employee['city']; ?></p>
                        <p><strong>Zip:</strong> <?php echo $employee['zip']; ?></p>
                        <p><strong>Marital Status:</strong> <?php echo $employee['marital_status']; ?></p>
                        <p><strong>Department:</strong> <?php echo $employee['department']; ?></p>
                        <p><strong>Basic Pay:</strong> <?php echo $employee['basic_pay']; ?></p>
                        <p><strong>Employee Type:</strong> <?php echo $employee['employee_type']; ?></p>
                        <p><strong>Password:</strong> <input type="password" id="password"
                                value="<?php echo $employee['password']; ?>" disabled>
                            <button type="button" class="btn btn-primary btn-sm" onclick="togglePasswordVisibility()">
                                <i class="fa fa-eye"></i>
                            </button>
                        </p>
                    </div>
                </div>
                <button class="btn-back" onclick="window.location.href='employee_dashboard.php'">
                    <i class="fa fa-arrow-left"></i> Back to Dashboard
                </button>
            </div>
        </div>
    </div>

    <!-- Add Font Awesome (FontAwesome) CDN to use the icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <!-- JavaScript code for toggling password visibility -->
    <script>
    function togglePasswordVisibility() {
        const passwordField = document.getElementById('password');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    }
    </script>
</body>

</html>