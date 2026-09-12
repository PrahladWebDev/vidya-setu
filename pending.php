<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="your-styles.css">
    <title>Pending Data</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }

        h1 {
            color: #ff6666;
            margin-bottom: 20px;
        }

        .card {
            width: 80%;
            margin: 20px auto;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #ffcccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sub-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-info {
            text-align: left;
        }

        .card-link {
            text-decoration: none;
            color: #ff6666;
            border: 2px solid #ff6666;
            padding: 8px 12px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .card-link:hover {
            background-color: #ff6666;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    include('database.php');

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
        header("Location: index.php"); // Redirect to login page if not logged in or not a user
        exit();
    }

    $userID = $_SESSION['id'];

    // Prepare and execute a SELECT query to fetch all pending rows for the user with region_name
    $sql = "SELECT faculty_data.*, regions.region_name
        FROM faculty_data
        LEFT JOIN regions ON faculty_data.region_id = regions.region_id
        WHERE faculty_data.user_id = ? AND faculty_data.status = 'Pending'";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Display the data in cards or any other format
            ?>
            <div class="card">
                <div class="sub-card">
                    <div class="card-info">
                        <h2>User ID: <?php echo htmlspecialchars($row["user_id"]); ?></h2>
                        <p>Name: <?php echo htmlspecialchars($row["name"]); ?></p>
                        <p>Department: <?php echo htmlspecialchars($row["department"]); ?></p>
                        <p>Region: <?php echo htmlspecialchars($row["region_name"]); ?></p>
                        <p>Start Date: <?php echo htmlspecialchars($row["tsdate"]); ?></p>
                        <p>End Date: <?php echo htmlspecialchars($row["tedate"]); ?></p>
                        <p>Status: <?php echo htmlspecialchars($row["status"]); ?></p>
                        <!-- Add more data fields as required -->
                    </div>
                    <div>
                        <a href="faculty_panel.php?id=<?php echo htmlspecialchars($row["id"]); ?>" class="card-link">View</a>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<h1>No pending records found for the user with user_id $userID.</h1>";
    }

    // Close the database connection
    $con->close();
    ?>
</body>

</html>
