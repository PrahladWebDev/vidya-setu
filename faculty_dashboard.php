<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="your-styles.css">
    <title>Faculty Panel</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .card {
            width: 80%;
            margin: 20px auto;
            padding: 15px;
            background-color: #ffe6e6;
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
            cursor: pointer;
        }

        .card-link:hover {
            background-color: #ffd9d9;
            color: #ff3333;
            border: 2px solid #ff6666;
            padding: 8px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    include('database.php');

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
        header("Location: index.php");
        exit();
    }

    $userID = $_SESSION['id'];

    $sql = "SELECT faculty_data.*, regions.region_name
        FROM faculty_data
        LEFT JOIN regions ON faculty_data.region_id = regions.region_id
        WHERE faculty_data.user_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="card">
                <div class="sub-card">
                    <div class="card-info">
                        <h2>User ID: <?php echo htmlspecialchars($row["user_id"]); ?></h2>
                        <p>Name: <?php echo htmlspecialchars($row["name"]); ?></p>
                        <p>Id: <?php echo htmlspecialchars($row["id"]); ?></p>
                        <p>Department: <?php echo htmlspecialchars($row["department"]); ?></p>
                        <p>Region: <?php echo htmlspecialchars($row["region_name"]); ?></p>
                        <p>Start Date: <?php echo htmlspecialchars($row["tsdate"]); ?></p>
                        <p>End Date: <?php echo htmlspecialchars($row["tedate"]); ?></p>
                        <p>Status: <?php echo htmlspecialchars($row["status"]); ?></p>
                    </div>
                    <div>
                        <a href="faculty_panel.php?id=<?php echo htmlspecialchars($row["id"]); ?>" class="card-link">View</a>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No records found for the user with user_id $user_id.</p>";
    }

    $con->close();
    ?>
</body>

</html>
