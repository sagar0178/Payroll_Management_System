<?php
require_once('config.php');

// Fetch overtime data for each employee
$select_query = "SELECT ob.employee_id, SUM(ob.overtime_hours) AS total_overtime, SUM(ob.bonus_amount) AS total_bonus
                 FROM overtime_bonus ob
                 GROUP BY ob.employee_id";
$result = $conn->query($select_query);

// Calculate and update overtime and bonus amount in income table
while ($row = $result->fetch_assoc()) {
    $employee_id = $row['employee_id'];
    $total_overtime = $row['total_overtime'];
    $total_bonus = $row['total_bonus'];

    // Fetch basic_pay of the employee from employees table
    $basic_pay_query = "SELECT basic_pay FROM employees WHERE id = ?";
    $stmt = $conn->prepare($basic_pay_query);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $stmt->bind_result($basic_pay);
    $stmt->fetch();
    $stmt->close();

    // Calculate overtime pay (1.5 times basic salary)
    $overtime_pay = (1.5 * $basic_pay * $total_overtime) / (30 * 8);

    // Update income table
    $update_query = "UPDATE income
                     SET overtime = ?,
                         bonus = ?,
                         basic_pay = ?,
                         total = basic_pay + ?,
                         deductions = 0,
                         net_pay = total
                     WHERE employee_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ddddd", $overtime_pay, $total_bonus, $basic_pay, $total_bonus, $employee_id);
    $stmt->execute();
    $stmt->close();
}

// Close the database connection
$conn->close();