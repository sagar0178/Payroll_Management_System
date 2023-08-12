<?php
// leave.php

// Include the database configuration file
require_once 'config.php';

// Function to get leaves data from the database
function getLeavesData()
{
    global $conn;
    $sql = "SELECT leaves.*, employees.name FROM leaves 
          INNER JOIN employees ON leaves.employee_id = employees.id";
    $result = $conn->query($sql);
    $leaves_data = array();

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $leaves_data[] = $row;
            }
        }
        $result->free();
    } else {
        echo "Error executing query: " . $conn->error;
    }

    return $leaves_data;
}

// Function to update leave_status
function updateLeaveStatus($leave_id, $leave_status)
{
    global $conn;
    $sql = "UPDATE leaves SET leave_status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $leave_status, $leave_id);

    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error updating leave_status: " . $conn->error;
        return false;
    }
}

// Check if the form is submitted for leave_status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['leave_id']) && isset($_POST['leave_status'])) {
    $leave_id = $_POST['leave_id'];
    $leave_status = $_POST['leave_status'];

    if (updateLeaveStatus($leave_id, $leave_status)) {
        // Leave_status updated successfully
        header('Location: leave.php');
        exit;
    }
}

// Get leaves data from the database
$leaves_data = getLeavesData();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Leaves Management</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center">Leaves Management</h1>
        <table class="table table-bordered table-striped mt-4">
            <tr>
                <th>ID</th>
                <th>Employee Name</th>
                <th>Leave Reason</th>
                <th>Address</th>
                <th>Leave Type</th>
                <th>Leave Status</th>
            </tr>
            <?php foreach ($leaves_data as $leave) : ?>
            <tr>
                <td><?php echo $leave['id']; ?></td>
                <td><?php echo $leave['name']; ?></td>
                <td><?php echo $leave['leave_reason']; ?></td>
                <td><?php echo $leave['address']; ?></td>
                <td><?php echo $leave['leave_type']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="leave_id" value="<?php echo $leave['id']; ?>">
                        <select name="leave_status">
                            <option value=""> </option> <!-- Blank option -->
                            <option value="pending" <?php if ($leave['leave_status'] === 'pending') echo 'selected'; ?>>
                                Pending</option>
                            <option value="Approved"
                                <?php if ($leave['leave_status'] === 'Approved') echo 'selected'; ?>>Approved</option>
                            <option value="Rejected"
                                <?php if ($leave['leave_status'] === 'Rejected') echo 'selected'; ?>>Rejected</option>
                        </select>
                        <input type="submit" value="Update" class="btn btn-primary btn-sm ml-2">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="admin_dashboard.php" class="btn btn-danger">Back</a>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>