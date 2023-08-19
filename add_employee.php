<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Main content -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Employee</h4>
                        <form action="process_add_employee.php" method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" required
                                    placeholder="Name">
                            </div>

                            <div class="form-group">
                                <select class="form-control" id="department" name="department" required>
                                    <!-- PHP code to fetch department names and populate the dropdown options -->
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
                                            echo '<option value="' . $row['department_name'] . '">' . $row['department_name'] . '</option>';
                                        }
                                    }

                                    $conn->close();
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="employee_type" name="employee_type" required
                                    placeholder="Employee Type">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="basic_pay" name="basic_pay" required
                                    placeholder="Basic Pay">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="contact" name="contact" required
                                    placeholder="Contact">
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control" id="email" name="email" required
                                    placeholder="Email">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="home_address" name="home_address" required
                                    placeholder="Home Address">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="city" name="city" required
                                    placeholder="City">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="zip" name="zip" required placeholder="ZIP">
                            </div>

                            <div class="form-group">
                                <select class="form-control" id="marital_status" name="marital_status" required>
                                    <option value="Married">Married</option>
                                    <option value="Unmarried">Unmarried</option>
                                </select>
                            </div>



                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Add Employee</button>
                                <button type="button" class="btn btn-danger" onclick="goBack()">Back</button>

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
    <!-- Link Custom JS -->
    <script src="script.js"></script>
</body>

</html>