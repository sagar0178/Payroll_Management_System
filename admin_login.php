<?php
// Include the database configuration file
require_once 'config.php';

// Function to sanitize input data
function sanitize($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    // Establish database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the query to fetch admin data
    $sql = "SELECT id FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    // Check if the admin credentials are valid
    if ($stmt->num_rows > 0) {
        // Valid login, redirect to admin_dashboard.php
        header('Location: admin_dashboard.php');
        exit;
    } else {
        // Invalid credentials, show error message
        $error = 'Invalid username or password';
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ... -->
</head>

<body>
    <div class="container">
        <!-- ... -->
    </div>
    <!-- ... -->
</body>

</html>