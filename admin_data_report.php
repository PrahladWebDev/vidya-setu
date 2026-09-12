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
    <title>View Persons</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        div.card {
            width: 80%;
            margin: 20px auto;
            padding: 15px;
            background-color: #ffe6e6; /* Light red background color */
            border: 1px solid #ffcccc; /* Light red border */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        h2 {
            color: #ff6666; /* Dark red text color */
            margin-bottom: 10px;
        }

        a.btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #ff6666; /* Dark red background color */
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
            transition: background-color 0.3s ease-in-out;
        }

        a.btn:hover {
            background-color: #ff3333; /* Darker red on hover */
        }

        a.goBack {
            display: inline-block;
            padding: 8px 16px;
            background-color: #ccc;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
            transition: background-color 0.3s ease-in-out;
        }

        a.goBack:hover {
            background-color: #999;
        }
    </style>
</head>

<body>
    <h1>View Persons</h1>

    <?php
    include('database.php'); // Include the database connection

    $sql = "SELECT DISTINCT name, user_id FROM faculty_fill_data";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<h2>Person Name: " . htmlspecialchars($row["name"]) . "</h2>";
            echo "<h2>User Id: " . htmlspecialchars($row["user_id"]) . "</h2>";
            echo "<a href='view_person_data.php?user_id=" . (int) $row['user_id'] . "' class='btn'>View</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No persons found.</p>";
    }
    ?>

    <a href="admin.php" class="goBack">Go Back</a>
</body>

</html>
