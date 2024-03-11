<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Tracker System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.9.55/css/materialdesignicons.min.css">

    <style>
        .main {
            display: flex;
            padding-top: 70px;
        }

        h2 {
            color: blueviolet;
        }

        /* Table styles */
        .table {
            color: white; /* Text color for table cells */
        }

        tr {
            color: white;
        }

        td {
            color: black;
        }

        .thead {
            background-color: #b66dff;
        }

        th.action {
            vertical-align: middle;
            text-align: center;
            color: black; /* Text color for the "Edit" and "Delete" links */
        }

        /* Icon styles */
        .mdi-icon {
            font-size: 24px;
            color: black;
            margin-right: 10px;
        }

        /* Pagination styles */
        .pagination .page-item .page-link {
            color: black;
        }
        .icon {
            float: right;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <?php include("header.php"); ?>
    </header>

    <div class="main">
        <sidebar>
            <?php include("sidebar.php"); ?>
        </sidebar>
        <div class="content-wrapper">
        <div class="container mt-5">
            <h2>View Category</h2>
            <div class="icon">
                <div class="filter-dropdown">
                    <label for="filter">Filter by:</label>
                    <select id="filter" name="filter">
                        <option value="all">All</option>
                        <?php
                        // Database connection details
                        $host = 'localhost';
                        $username = 'root';
                        $password = '';
                        $database = 'expense_db';

                        // Create connection
                        $conn = new mysqli($host, $username, $password, $database);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Fetch categories from the database
                        $category_query = "SELECT * FROM expenses_categories";
                        $category_result = $conn->query($category_query);
                        if ($category_result->num_rows > 0) {
                            while ($category_row = $category_result->fetch_assoc()) {
                                $category_id = $category_row['category_id'];
                                $category_name = $category_row['category_name'];
                                echo "<option value='$category_id'>$category_name</option>";
                            }
                        }
                        ?>
                    </select>
                    <button onclick="applyFilter()">Apply</button>
                </div>
            </div>

            <script>
                function applyFilter() {
                    var filterValue = document.getElementById('filter').value;
                    var categories = document.querySelectorAll('.category-row');

                    categories.forEach(function (category) {
                        var categoryId = category.getAttribute('data-category-id');
                        if (filterValue === 'all' || categoryId === filterValue) {
                            category.style.display = 'table-row';
                        } else {
                            category.style.display = 'none';
                        }
                    });
                }
            </script>

            <?php
            // Database connection details already established above

            $sql = "SELECT DISTINCT users.user_id AS user_id, users.username AS username, users.email AS email, ec.category_id, ec.category_name
            FROM users
            INNER JOIN expenses_categories ec ON users.user_id = ec.user_id";
            $result = $conn->query($sql);

            // Check if any users who added categories exist
            if ($result->num_rows > 0) {
                // Output data of each user who added a category
                while ($row = $result->fetch_assoc()) {
                    $username = $row["username"];
                    $email = $row["email"];
                    echo "<h3>User: $username ($email)</h3>";

                    // Output table for categories
                    echo "<table class='table table-bordered table-hover'>"; 
                    echo "<thead class='thead'>";
                    echo "<tr>";
                    echo "<th>Category ID</th>";
                    echo "<th>Name</th>";
                    echo "<th>Action</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    // Output data of each category for this user
                    echo "<tr class='category-row' data-category-id='" . $row["category_id"] . "'>";
                    echo "<td>" . $row["category_id"] . "</td>";
                    echo "<td>" . $row["category_name"] . "</td>";
                    echo "<td class='action' style='text-align: center; vertical-align: middle;'><a href='editexpense_category.php?id=" . $row["category_id"] . "'><i class='mdi mdi-tooltip-edit mdi-icon'></i></a> <a href='deleteexpense_category.php?id=" . $row["category_id"] . "'><i class='mdi mdi-delete mdi-icon'></i></a></td>";
                    echo "</tr>";

                    echo "</tbody>";
                    echo "</table>";
                }
            } else {
                echo "No users who have added categories found.";
            }

           

            $results_per_page = 10; // Set the desired number of results per page
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $offset = ($page - 1) * $results_per_page;
            ?>
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
            <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
        </div>
    </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>
</html>
