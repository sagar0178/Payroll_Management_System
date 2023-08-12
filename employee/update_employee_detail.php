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

// Define an array of fields that cannot be updated
$non_editable_fields = ['id', 'email', 'department', 'basic_pay', 'employee_type'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update the employee details
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $home_address = $_POST['home_address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $marital_status = $_POST['marital_status'];

    // Perform update query here with the updated details
    $update_query = "UPDATE employees SET name=?, contact=?, home_address=?, city=?, zip=?, marital_status=? WHERE id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssi", $name, $contact, $home_address, $city, $zip, $marital_status, $employee_id);
    if ($stmt->execute()) {
        // Redirect to view_employee_details.php after updating
        header('Location: view_employee_details.php');
        exit();
    } else {
        // Error handling if the update fails
        $error_message = "Error: Unable to update employee details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee Details</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link Custom CSS -->
    <style>
    .card-content {
        /* Styles for the card content */
    }

    /* Add CSS for the back button */
    .back-button {
        /* Styles for the back button */
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card card-content">
                    <div class="card-body">
                        <h4 class="card-title">Update Employee Details</h4>
                        <form method="post">
                            <p><strong>Name:</strong> <input type="text" name="name"
                                    value="<?php echo $employee['name']; ?>"
                                    <?php echo in_array('name', $non_editable_fields) ? 'readonly' : ''; ?>></p>
                            <p><strong>Email:</strong> <?php echo $employee['email']; ?></p>
                            <p><strong>Contact:</strong> <input type="text" name="contact"
                                    value="<?php echo $employee['contact']; ?>"
                                    <?php echo in_array('contact', $non_editable_fields) ? 'readonly' : ''; ?>></p>
                            <p><strong>Address:</strong> <input type="text" name="home_address"
                                    value="<?php echo $employee['home_address']; ?>"
                                    <?php echo in_array('home_address', $non_editable_fields) ? 'readonly' : ''; ?>></p>
                            <p><strong>City:</strong> <input type="text" name="city"
                                    value="<?php echo $employee['city']; ?>"
                                    <?php echo in_array('city', $non_editable_fields) ? 'readonly' : ''; ?>></p>
                            <p><strong>Zip:</strong> <input type="text" name="zip"
                                    value="<?php echo $employee['zip']; ?>"
                                    <?php echo in_array('zip', $non_editable_fields) ? 'readonly' : ''; ?>></p>
                            <p><strong>Marital Status:</strong>
                                <select name="marital_status"
                                    <?php echo in_array('marital_status', $non_editable_fields) ? 'disabled' : ''; ?>>
                                    <option value="Married"
                                        <?php echo $employee['marital_status'] === 'Married' ? 'selected' : ''; ?>>
                                        Married</option>
                                    <option value="Unmarried"
                                        <?php echo $employee['marital_status'] === 'Unmarried' ? 'selected' : ''; ?>>
                                        Unmarried</option>
                                </select>
                            </p>
                            <button type="submit" class="btn btn-primary"
                                <?php echo in_array('password', $non_editable_fields) ? 'disabled' : ''; ?>>Save
                                Changes</button>
                        </form>
                    </div>
                </div>
                <a href="employee_dashboard.php" class="btn btn-danger mt-3 back-button">Back</a>
            </div>
        </div>
    </div>
    <!-- Add Font Awesome (FontAwesome) CDN to use the icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <!-- JavaScript code for toggling password visibility (if needed) -->
    <script>
    // ... (Same JavaScript code as before) ...
    </script>
</body>

</html>