<?php
// Start the session to access session variables
session_start();

// Include the database configuration file
require_once 'config.php';

// Establish database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch employee data from the employees table
$employee_ids = array();
$employee_names = array();
$sql = "SELECT id, name FROM employees";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employee_ids[] = $row['id'];
        $employee_names[$row['id']] = $row['name'];
    }
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the input data
    $overtime_hours = $_POST['overtime_hours'] ?? array();
    $bonus_amount = $_POST['bonus_amount'] ?? array();

    // Loop through the submitted data and update the overtime_bonus table
    foreach ($employee_ids as $employee_id) {
        $overtime_hours_input = isset($overtime_hours[$employee_id]) ? intval($overtime_hours[$employee_id]) : 0;
        $bonus_amount_input = isset($bonus_amount[$employee_id]) ? intval($bonus_amount[$employee_id]) : 0;

        // Check if the data already exists in the overtime_bonus table
        $sql = "SELECT * FROM overtime_bonus WHERE employee_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update the existing data
            $sql = "UPDATE overtime_bonus SET overtime_hours = ?, bonus_amount = ? WHERE employee_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $overtime_hours_input, $bonus_amount_input, $employee_id);
            $stmt->execute();
        } else {
            // Insert new data into the overtime_bonus table
            $sql = "INSERT INTO overtime_bonus (employee_id, overtime_hours, bonus_amount) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $employee_id, $overtime_hours_input, $bonus_amount_input);
            $stmt->execute();
        }
    }

    // Set a success message and redirect back to the same page
    $_SESSION['success_message'] = "Data updated successfully.";
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

// Fetch data from the overtime_bonus table and store it in an array
$overtime_bonus_data = array();
$sql = "SELECT * FROM overtime_bonus";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $overtime_bonus_data[$row['employee_id']] = array(
            'overtime_hours' => $row['overtime_hours'],
            'bonus_amount' => $row['bonus_amount']
        );
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Overtime and Bonus</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <a href="admin_dashboard.php" class="btn btn-primary mb-3">Back</a>
                        <h4 class="card-title">Add Overtime and Bonus</h4>
                        <?php
                        if (isset($_SESSION['success_message'])) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    ' . $_SESSION['success_message'] . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                            unset($_SESSION['success_message']);
                        }

                        if (isset($_SESSION['error_message'])) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    ' . $_SESSION['error_message'] . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                            unset($_SESSION['error_message']);
                        }
                        ?>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th>Overtime Hours</th>
                                            <th>Bonus Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($employee_ids as $employee_id) : ?>
                                        <tr>
                                            <td><?php echo $employee_id; ?></td>
                                            <td><?php echo $employee_names[$employee_id]; ?></td>
                                            <td><input type="number" name="overtime_hours[<?php echo $employee_id; ?>]"
                                                    value="<?php echo $overtime_bonus_data[$employee_id]['overtime_hours'] ?? 0; ?>">
                                            </td>
                                            <td><input type="number" name="bonus_amount[<?php echo $employee_id; ?>]"
                                                    value="<?php echo $overtime_bonus_data[$employee_id]['bonus_amount'] ?? 0; ?>">
                                            </td>
                                            <td>
                                                <button type="submit"
                                                    class="btn btn-primary add-update-button">Add/Update</button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Link Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include your custom script.js file -->
    <script src="script.js"></script>
</body>

</html>