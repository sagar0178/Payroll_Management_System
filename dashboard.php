<?php
// include 'auth.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Update Tax-OT-Bonus</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: auto;
        padding: 20px;
        text-align: center;
        background-color: #fff;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #333;
    }

    .button-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .button {
        padding: 10px 20px;
        margin: 0 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .button:hover {
        background-color: #0056b3;
    }

    .back-button {
        display: block;
        margin-top: 20px;
        color: #007bff;
        text-decoration: none;
        transition: color 0.3s;
    }

    .back-button:hover {
        color: #0056b3;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Update Tax-OT-Bonus</h1>

        <div class="button-container">
            <button class="button" id="button3">Update Income</button>
            <button class="button" id="button1">Update Tax</button>
            <button class="button" id="button2">Update OT Bonus</button>
        </div>

        <a href="admin_dashboard.php" class="back-button">Back to Admin Dashboard</a>
    </div>

    <script>
    // Add event listeners to the buttons
    document.getElementById("button3").addEventListener("click", function() {
        window.location.href = "employee/update_income.php"; // Redirect to page2.php
    });
    document.getElementById("button1").addEventListener("click", function() {
        window.location.href = "calculate_tax.php"; // Redirect to page1.php
    });

    document.getElementById("button2").addEventListener("click", function() {
        window.location.href = "employee/calculate_overtime.php"; // Redirect to page2.php
    });
    </script>
</body>

</html>