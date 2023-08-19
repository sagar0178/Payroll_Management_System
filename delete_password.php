<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Password</title>
    <link rel="stylesheet" href="dpassword.css">

</head>

<body>
    <div class="container">
        <h1>Empty Password for Employee</h1>
        <form method="post">
            <label for="employee_id">Enter Employee ID:</label>
            <input type="text" id="employee_id" name="employee_id">
            <button type="submit" name="search">Search</button>
        </form>

        <?php
        require_once('config.php'); // Include your database connection

        if (isset($_POST['search'])) {
            $employee_id_to_search = $_POST['employee_id'];

            $query = "SELECT * FROM employees WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $employee_id_to_search);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $employee_data = $result->fetch_assoc();
                echo '<div class="employee-info">';
                echo "<h2>Employee Information</h2>";
                echo "<p>Name: {$employee_data['name']}</p>";
                echo "<p>Department: {$employee_data['department']}</p>";
                echo "<p>Employee Type: {$employee_data['employee_type']}</p>";
                echo "<p>Basic Pay: {$employee_data['basic_pay']}</p>";
                echo "<p>Contact: {$employee_data['contact']}</p>";
                echo "<p>Email: {$employee_data['email']}</p>";
                echo "<p>Home Address: {$employee_data['home_address']}</p>";
                echo "<p>City: {$employee_data['city']}</p>";
                echo "<p>Zip: {$employee_data['zip']}</p>";
                echo "<p>Marital Status: {$employee_data['marital_status']}</p>";
                echo '<form method="post">';
                echo "<input type='hidden' name='employee_id' value='$employee_id_to_search'>";
                echo "<button type='submit' name='delete_password'>Delete Password</button>";
                echo '</form>';
                echo '</div>';
            } else {
                echo "<p>Employee with ID $employee_id_to_search does not exist.</p>";
            }

            $stmt->close();
        }

        if (isset($_POST['delete_password'])) {
            $employee_id_to_delete = $_POST['employee_id'];

            $update_query = "UPDATE employees SET password = '' WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("i", $employee_id_to_delete);

            if ($update_stmt->execute()) {
                echo "<p>Password for employee with ID $employee_id_to_delete has been emptied.</p>";
            } else {
                echo "<p>Error updating password: " . $update_stmt->error . "</p>";
            }

            $update_stmt->close();
        }

        // Close the database connection
        $conn->close();
        ?>

        <br>
        <a href="employee_management.php">Back to Admin Dashboard</a>
    </div>
</body>

</html>