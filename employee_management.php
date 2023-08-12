<?php
// Start the session to access session variables
session_start();

// Include the database configuration file
require_once 'config.php';

// Establish database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to perform Quick Sort
function quickSort(&$arr, $left, $right, $sortColumn, $sortOrder)
{
    if ($left < $right) {
        $pivotIndex = partition($arr, $left, $right, $sortColumn, $sortOrder);
        quickSort($arr, $left, $pivotIndex - 1, $sortColumn, $sortOrder);
        quickSort($arr, $pivotIndex + 1, $right, $sortColumn, $sortOrder);
    }
}

function partition(&$arr, $left, $right, $sortColumn, $sortOrder)
{
    $pivotValue = $arr[$right][$sortColumn];
    $pivotIndex = $left;

    for ($i = $left; $i < $right; $i++) {
        if ($sortOrder === 'asc') {
            if ($arr[$i][$sortColumn] < $pivotValue) {
                swap($arr, $i, $pivotIndex);
                $pivotIndex++;
            }
        } else {
            if ($arr[$i][$sortColumn] > $pivotValue) {
                swap($arr, $i, $pivotIndex);
                $pivotIndex++;
            }
        }
    }

    swap($arr, $pivotIndex, $right);
    return $pivotIndex;
}

function swap(&$arr, $i, $j)
{
    $temp = $arr[$i];
    $arr[$i] = $arr[$j];
    $arr[$j] = $temp;
}
// Function to get employee data from the database
function getEmployeeData($conn, $sortColumn, $sortOrder, $searchQuery)
{
    // Use the provided search query to filter the SQL results
    $searchFilter = '';
    if (!empty($searchQuery)) {
        $searchFilter = "WHERE 
            id LIKE '%$searchQuery%' OR
            name LIKE '%$searchQuery%' OR
            department LIKE '%$searchQuery%' OR
            employee_type LIKE '%$searchQuery%' OR
            basic_pay LIKE '%$searchQuery%' OR
            contact LIKE '%$searchQuery%' OR
            email LIKE '%$searchQuery%' OR
            home_address LIKE '%$searchQuery%' OR
            city LIKE '%$searchQuery%' OR
            zip LIKE '%$searchQuery%' OR
            marital_status LIKE '%$searchQuery%'";
    }

    // Fetch employees based on the search filter
    $sql = "SELECT * FROM employees $searchFilter";
    $result = $conn->query($sql);

    $employeeData = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $employeeData[] = $row;
        }
    }

    quickSort($employeeData, 0, count($employeeData) - 1, $sortColumn, $sortOrder);

    return $employeeData;
}

// Set default sorting parameters
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$sortOrder = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Set default search query
$searchQuery = '';

// Handle search form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_query'])) {
    $searchQuery = $_POST['search_query'];
}

// Get employee data from the database with the provided search query
$employeeData = getEmployeeData($conn, $sortColumn, $sortOrder, $searchQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Link Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <main class="col-md-12 ms-sm-auto col-lg-10 px-md-0 m-auto">
        <!-- Place the success message code inside a separate row and column -->
        <?php
        if (isset($_SESSION['success_message'])) {
            echo '<div class="container mt-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        ' . $_SESSION['success_message'] . '
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>';
            // Remove the success message from the session after displaying it
            unset($_SESSION['success_message']);
        }
        ?>

        <!-- Search Bar -->
        <div class="card mt-4">
            <div class="card-body">
                <form method="post" class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" name="search_query" value="<?php echo $searchQuery; ?>"
                            placeholder="Search...">
                    </div>
                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                </form>
            </div>
        </div>

        <!-- Employee Management Module -->
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" onclick="goBack()">Back</button>
                <h4 class="card-title">Employee Management Module</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <a
                                        href="?sort=id&order=<?php echo $sortColumn === 'id' && $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">
                                        ID
                                        <?php if ($sortColumn === 'id') echo $sortOrder === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>'; ?>
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="?sort=name&order=<?php echo $sortColumn === 'name' && $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">
                                        Name
                                        <?php if ($sortColumn === 'name') echo $sortOrder === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>'; ?>
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="?sort=department&order=<?php echo $sortColumn === 'department' && $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">
                                        Department
                                        <?php if ($sortColumn === 'department') echo $sortOrder === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>'; ?>
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="?sort=employee_type&order=<?php echo $sortColumn === 'employee_type' && $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">
                                        Employee Type
                                        <?php if ($sortColumn === 'employee_type') echo $sortOrder === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>'; ?>
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="?sort=basic_pay&order=<?php echo $sortColumn === 'basic_pay' && $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">
                                        Basic Pay
                                        <?php if ($sortColumn === 'basic_pay') echo $sortOrder === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>'; ?>
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="?sort=contact&order=<?php echo $sortColumn === 'contact' && $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">
                                        Contact
                                        <?php if ($sortColumn === 'contact') echo $sortOrder === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>'; ?>
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="?sort=email&order=<?php echo $sortColumn === 'email' && $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">
                                        Email
                                        <?php if ($sortColumn === 'email') echo $sortOrder === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>'; ?>
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="?sort=home_address&order=<?php echo $sortColumn === 'home_address' && $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">
                                        Home Address
                                        <?php if ($sortColumn === 'home_address') echo $sortOrder === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>'; ?>
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="?sort=city&order=<?php echo $sortColumn === 'city' && $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">
                                        City
                                        <?php if ($sortColumn === 'city') echo $sortOrder === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>'; ?>
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="?sort=zip&order=<?php echo $sortColumn === 'zip' && $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">
                                        ZIP
                                        <?php if ($sortColumn === 'zip') echo $sortOrder === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>'; ?>
                                    </a>
                                </th>
                                <th>
                                    <a
                                        href="?sort=marital_status&order=<?php echo $sortColumn === 'marital_status' && $sortOrder === 'asc' ? 'desc' : 'asc'; ?>">
                                        Marital Status
                                        <?php if ($sortColumn === 'marital_status') echo $sortOrder === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>'; ?>
                                    </a>
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- PHP code to fetch and display employees from the database -->
                            <?php
                            foreach ($employeeData as $row) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['department'] . "</td>";
                                echo "<td>" . $row['employee_type'] . "</td>";
                                echo "<td>" . $row['basic_pay'] . "</td>";
                                echo "<td>" . $row['contact'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['home_address'] . "</td>";
                                echo "<td>" . $row['city'] . "</td>";
                                echo "<td>" . $row['zip'] . "</td>";
                                echo "<td>" . $row['marital_status'] . "</td>";
                                echo "<td>
                                
                                      <a href='edit_employee.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'>Edit</a>
                                      <a href='delete_employee.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                                      
                                    </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Main content area -->
        <div class="card card-content mt-4">
            <div class="card-body">
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">Add Employee</button>
                </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Link Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Link Custom JS -->
    <script src="script.js"></script>
</body>

</html>