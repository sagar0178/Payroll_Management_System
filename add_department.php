<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Department</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Main content -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Department</h4>
                        <form action="process_add_department.php" method="POST">
                            <div class="form-group">
                                <label for="department">Department Name </label><br>
                                <input type="text" class="form-control" id="department" name="department" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Add Department</button>
                                <button type="button" class="btn btn-danger" onclick="goBack()">Back</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Link Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Link Custom JS -->
    <script src="script.js"></script>
</body>

</html>