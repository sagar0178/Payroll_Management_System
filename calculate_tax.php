<?php
// Include the database configuration
require_once('config.php');
include 'auth.php';

// Fetch data from income and employees tables using a join
$query = "SELECT income.employee_id, income.total, employees.marital_status FROM income
          JOIN employees ON income.employee_id = employees.id";
$result = $conn->query($query);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $employee_id = $row['employee_id'];
        $total_income = $row['total'];
        $marital_status = $row['marital_status'];

        // Tax calculation based on marital status and income
        $tax_amount = 0;

        // Calculate tax for unmarried individuals
        if ($marital_status === 'Unmarried') {
            if ($total_income <= 500000) {
                $tax_amount = $total_income * 0.01;
            } elseif ($total_income <= 700000) {
                $tax_amount = 5000 + ($total_income - 500000) * 0.1;
            } elseif ($total_income <= 1000000) {
                $tax_amount = 25000 + ($total_income - 700000) * 0.2;
            } elseif ($total_income <= 2000000) {
                $tax_amount = 75000 + ($total_income - 1000000) * 0.3;
            } else {
                $tax_amount = 375000 + ($total_income - 2000000) * 0.36;
            }

        // Calculate tax for married individuals
        } elseif ($marital_status === 'Married') {
            if ($total_income <= 600000) {
                $tax_amount = $total_income * 0.01;
            } elseif ($total_income <= 800000) {
                $tax_amount = 6000 + ($total_income - 600000) * 0.1;
            } elseif ($total_income <= 1100000) {
                $tax_amount = 26000 + ($total_income - 800000) * 0.2;
            } elseif ($total_income <= 2350000) {
                $tax_amount = 46000 + ($total_income - 1100000) * 0.3;
            } else {
                $tax_amount = 171000 + ($total_income - 2350000) * 0.36;
            }
        }

        // Check if there's an existing record for the employee in the deductions table
        $check_query = "SELECT * FROM deductions WHERE employee_id = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $existing_record = $stmt->fetch();
        $stmt->close();

        // Insert or update tax deduction data into deductions table
        if ($existing_record) {
            $update_query = "UPDATE deductions SET tax_deduction_amount = ? WHERE employee_id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("di", $tax_amount, $employee_id);
            $stmt->execute();
        } else {
            $insert_query = "INSERT INTO deductions (employee_id, tax_deduction_amount) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("id", $employee_id, $tax_amount);
            $stmt->execute();
        }
    }

    echo "Tax calculation and insertion/update successful.";

    
} else {
    echo "Error fetching income data: " . $conn->error;
}


// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Calculation</title>
</head>

<body>
    <a href="dashboard.php" class="back-button">Back to Dashboard</a>
</body>

</html>