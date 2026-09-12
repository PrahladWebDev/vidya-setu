<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registered Users</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        .card {
            margin-bottom: 20px;
            border: 1px solid #ffcccc; /* Light red border */
            border-radius: 8px;
            overflow: hidden;
            background-color: #ffe6e6; /* Light red background color */
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.2rem;
            color: #ff6666; /* Dark red text color */
            margin-bottom: 10px;
        }

        .card-text {
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff6666; /* Dark red background color */
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease-in-out;
        }

        .btn:hover {
            background-color: #ff3333; /* Darker red on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>List of Registered Users</h1>

        <!-- User Department Dropdown -->
        <form method="GET" action="regi_list.php">
            <div style="margin-bottom: 20px;">
                <label for="departmentSelect">Select User by Department:</label>
                <select style="padding: 8px;" id="departmentSelect" name="selected_department">
                    <option value="">Select a Department</option>

                    <?php
                    include 'database.php'; // Include the database connection

                    $sql = "SELECT DISTINCT department FROM usersss";
                    $result = $con->query($sql);

                    $selectedDepartment = isset($_GET['selected_department']) ? $_GET['selected_department'] : '';

                    while ($row = $result->fetch_assoc()) {
                        $department = $row["department"];
                        $selected = ($department === $selectedDepartment) ? 'selected' : '';
                        echo "<option value='$department' $selected>$department</option>";
                    }
                    ?>
                </select>
            </div>
            <button style="padding: 10px 20px; background-color: #ff6666; /* Dark red background color */ color: #fff; border: none; border-radius: 4px; cursor: pointer;" type="submit">Search</button>
        </form>

        <?php
        if (isset($_GET['selected_department'])) {
            $selectedDepartment = $_GET['selected_department'];

            $stmt = $con->prepare("SELECT * FROM usersss WHERE department = ?");
            $stmt->bind_param("s", $selectedDepartment);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<h2>Search Results in ' . $selectedDepartment . ' Department</h2>';

                while ($row = $result->fetch_assoc()) {
        ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User ID: <?php echo htmlspecialchars($row["id"]); ?></h5>
                <p class="card-text">Name: <?php echo htmlspecialchars($row["name"]); ?></p>
                <p class="card-text">Department: <?php echo htmlspecialchars($row["department"]); ?></p>
                <a href="allotment.php?id=<?php echo htmlspecialchars($row["id"]); ?>" class="btn">Allotment</a>
            </div>
        </div>
        <?php
                }
            } else {
                echo "<p>No users found in the selected department.</p>";
            }
        }

        $sql = "SELECT * FROM usersss";
        $result = $con->query($sql);

        if ($result->num_rows > 0 && !isset($_GET['selected_department'])) {
            echo '<h2>All Users</h2>';

            while ($row = $result->fetch_assoc()) {
        ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">User ID: <?php echo htmlspecialchars($row["id"]); ?></h5>
                <p class="card-text">Name: <?php echo htmlspecialchars($row["name"]); ?></p>
                <p class="card-text">Department: <?php echo htmlspecialchars($row["department"]); ?></p>
                <a href="allotment.php?id=<?php echo htmlspecialchars($row["id"]); ?>" class="btn">Allotment</a>
            </div>
        </div>
        <?php
            }
        } elseif ($result->num_rows === 0 && !isset($_GET['selected_department'])) {
            echo "<p>No users found.</p>";
        }

        $con->close();
        ?>
    </div>
</body>

</html>
