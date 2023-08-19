<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $employee_id = $_GET['id'];
    require_once 'config.php';

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        $_SESSION['error_message'] = "Employee not found.";
        header("Location: admin_dashboard.php");
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['error_message'] = "Invalid request.";
    header("Location: employee_management.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Employee</h4>
                        <form action="update_employee.php" method="POST">
                            <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php echo $employee['name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select class="form-control" id="department" name="department" required>
                                    <?php
                                    require_once 'config.php';
                                    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    $sql = "SELECT department_name FROM departments";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $selected = ($employee['department'] === $row['department_name']) ? "selected" : "";
                                            echo '<option value="' . $row['department_name'] . '" ' . $selected . '>' . $row['department_name'] . '</option>';
                                        }
                                    }

                                    $conn->close();
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="employee_type">Employee Type</label>
                                <input type="text" class="form-control" id="employee_type" name="employee_type"
                                    value="<?php echo $employee['employee_type']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="basic_pay">Basic Pay</label>
                                <input type="text" class="form-control" id="basic_pay" name="basic_pay"
                                    value="<?php echo $employee['basic_pay']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="text" class="form-control" id="contact" name="contact"
                                    value="<?php echo $employee['contact']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo $employee['email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="home_address">Home Address</label>
                                <input type="text" class="form-control" id="home_address" name="home_address"
                                    value="<?php echo $employee['home_address']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city"
                                    value="<?php echo $employee['city']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="zip">ZIP</label>
                                <input type="text" class="form-control" id="zip" name="zip"
                                    value="<?php echo $employee['zip']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="marital_status">Marital Status</label>
                                <select class="form-control" id="marital_status" name="marital_status" required>
                                    <option value="Married"
                                        <?php if ($employee['marital_status'] === 'Married') echo 'selected'; ?>>Married
                                    </option>
                                    <option value="Unmarried"
                                        <?php if ($employee['marital_status'] === 'Unmarried') echo 'selected'; ?>>
                                        Unmarried</option>
                                </select>
                            </div>
                            <div class="text-center">

                                <button type="submit" class="btn btn-primary">Update
                                    Employee</button>
                                <button style="margin-top:16px;" type="button" class="btn btn-danger mb-3"
                                    onclick="go_Back()">Back</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>