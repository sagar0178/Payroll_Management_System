<?php
// Include the database configuration
require_once('../config.php');

// Check if the income table is empty
$check_query = "SELECT COUNT(*) AS count FROM income";
$check_result = $conn->query($check_query);
$row = $check_result->fetch_assoc();

if ($row['count'] === '0') {
    // Insert initial data for each employee
    $insert_query = "INSERT INTO income (employee_id, basic_pay, overtime, bonus, total, net_pay)
                     SELECT e.id, e.basic_pay, 0, 0, 0, 0 FROM employees e";
    $conn->query($insert_query);
}

// Update overtime and bonus amount in income table
$update_query = "UPDATE income i
                 JOIN (SELECT ob.employee_id, SUM(ob.overtime_hours) AS total_overtime, SUM(ob.bonus_amount) AS total_bonus
                       FROM overtime_bonus ob
                       GROUP BY ob.employee_id) t
                 ON i.employee_id = t.employee_id
                 JOIN employees e ON i.employee_id = e.id
                 SET i.overtime = (1.5 * e.basic_pay * t.total_overtime / (30 * 8)),
                     i.bonus = t.total_bonus,
                     i.total = e.basic_pay + (1.5 * e.basic_pay * t.total_overtime / (30 * 8)) + t.total_bonus";
$conn->query($update_query);

// Update tax deduction amount in income table
$update_tax_query = "UPDATE income i
                     JOIN deductions d ON i.employee_id = d.employee_id
                     SET i.deductions = d.tax_deduction_amount";
$conn->query($update_tax_query);

// Update net pay in income table
$update_net_pay_query = "UPDATE income
                         SET net_pay = total - deductions";
$conn->query($update_net_pay_query);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Income</title>
</head>

<body>
    <h1>Income Update</h1>
    <p>Initial data inserted, overtime, bonus, total, deductions, and net pay updated.</p>
</body>

</html>