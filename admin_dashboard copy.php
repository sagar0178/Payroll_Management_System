<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <!-- Main content -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <!-- Employee Management Module -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Employee Management Module</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Employee Type</th>
                                        <th>Basic Pay</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Home Address</th>
                                        <th>City</th>
                                        <th>Zip</th>
                                        <th>Marital Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- PHP code to fetch and display employees from the database -->
                                    <?php
                                    require_once 'config.php';

                                    // Establish database connection and fetch employees
                                    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }

                                    $sql = "SELECT * FROM employees";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row['id'] . "</td>";
                                            echo "<td>" . $row['name'] . "</td>";
                                            echo "<td>" . $row['department'] . "</td>";
                                            echo "<td>" . $row['employee_type'] . "</td>";
                                            echo "<td>" . $row['basic_pay'] . "</td>";
                                            echo "<td>" . $row['contact'] . "</td>";
                                            echo "<td>" . $row['email'] . "</td>";
                                            echo "<td>" . $row['home_address'] . "</td>";
                                            echo "<td>" . $row['city'] . "</td>";
                                            echo "<td>" . $row['zip'] . "</td>";
                                            echo "<td>" . $row['marital_status'] . "</td>";
                                            echo "<td>
                              <a href='update_employee.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>
                              <a href='delete_employee.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                            </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='12'>No employees found</td></tr>";
                                    }

                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Add New Employee Submodule -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h4 class="card-title">Add New Employee Submodule</h4>
                        <form id="addEmployeeForm" action="add_employee.php" method="POST">
                            <!-- Form fields for adding a new employee -->
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" id="department" name="department" required>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">Add
                                    Employee</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ... -->

            </div>
        </div>
    </div>

    <!-- Link Bootstrap JS and jQuery -->
    <!-- ... -->
</body>

</html>