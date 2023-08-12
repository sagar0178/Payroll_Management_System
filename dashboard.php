<!DOCTYPE html>
<html>

<head>
    <title>Update Tax-OT-Bonus</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1>Update Tax-OT-Bonus</h1>

    <button id="button1">Update Tax </button>
    <button id="button2">Update OT BOnus</button>

    <a href="admin_dashboard.php" class="back-button">Back to Admin Dashboard</a>

    <script>
    // Add event listeners to the buttons
    document.getElementById("button1").addEventListener("click", function() {
        window.location.href = "calculate_tax.php"; // Redirect to page1.php
    });

    document.getElementById("button2").addEventListener("click", function() {
        window.location.href = "employee/calculate_overtime.php"; // Redirect to page2.php
    });
    </script>
</body>

</html>