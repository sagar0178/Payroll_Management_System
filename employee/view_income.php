<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Statement</title>
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #ccc;
    }

    th,
    td {
        padding: 10px;
    }

    .download-btn {
        display: inline-block;
        margin-top: 10px;
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Employee Income Statement</h1>
        <table>
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Basic Pay</th>
                    <th>Deductions</th>
                    <th>Overtime</th>
                    <th>Bonus</th>
                    <th>Total</th>
                    <th>Net Pay</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include your database connection file
                require_once('config.php');

                // Get the logged-in employee_id
                session_start();
                $employee_id = $_SESSION['employee_id'];

                // Fetch income data for the logged-in employee
                $query = "SELECT income.*, employees.name 
                          FROM income 
                          INNER JOIN employees ON income.employee_id = employees.id 
                          WHERE income.employee_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $employee_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['employee_id']}</td>";
                        echo "<td>{$row['basic_pay']}</td>";
                        echo "<td>{$row['deductions']}</td>";
                        echo "<td>{$row['overtime']}</td>";
                        echo "<td>{$row['bonus']}</td>";
                        echo "<td>{$row['total']}</td>";
                        echo "<td>{$row['net_pay']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No data available</td></tr>";
                }

                $stmt->close();
                $conn->close();
                ?>
            </tbody>
        </table>
        <a href="generate_pdf.php" class="download-btn">Download PDF</a>
        <a href="employee_dashboard.php" class="download-btn">Back</a>
    </div>
</body>

</html>