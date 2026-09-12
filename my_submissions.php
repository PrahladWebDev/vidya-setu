<!DOCTYPE html>
<html lang="en">

<head>
    <title>Inserted Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff; /* White background */
        }

        h1 {
            text-align: center;
            color: #ff3333; /* Light red color for heading */
        }

        div.card {
            border: 1px solid #ffcccc; /* Light red border */
            padding: 10px;
            margin: 10px;
            background-color: #ffe6e6; /* Light red background color */
        }

        h2 {
            color: #ff6666; /* Dark red color for headings */
        }

        p {
            color: #555;
        }

        a {
            text-decoration: none;
            color: #ff6666; /* Dark red color for links */
            border: 2px solid #ff6666; /* Dark red border */
            padding: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        a:hover {
            background-color: #ff6666; /* Dark red background color on hover */
            color: #fff; /* White text color on hover */
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

    $stmt = $con->prepare("SELECT * FROM faculty_fill_data WHERE user_id = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <h1>Inserted Data</h1>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<h2>Faculty Name: " . htmlspecialchars($row["tgtname"]) . "</h2>";
            echo "<p>Department: " . htmlspecialchars($row["tgtcont"]) . "</p>";
            echo "<p>Principal Name: " . htmlspecialchars($row["pname"]) . "</p>";
            echo "<p>Date: " . htmlspecialchars($row["date"]) . "</p>";

            echo "<a href='user_data_fill.php?id=" . htmlspecialchars($row['id']) . "'>View</a>";
            echo "</div>";
        }
    } else {
        echo "No data found.";
    }
    ?>

    <!-- Add a link to go back to the previous page if needed -->
</body>

</html>
