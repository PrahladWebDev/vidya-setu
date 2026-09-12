<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Data</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #333;
            text-align: center;
        }

        h1 {
            color: #ff6666;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ffcccc;
            text-align: left;
        }

        th {
            background-color: #ff6666;
            color: #fff;
        }

        a {
            text-decoration: none;
            color: #ff6666;
            border: 2px solid #ff6666;
            padding: 8px 12px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            transition: all 0.3s ease-in-out;
        }

        a:hover {
            background-color: #ff6666;
            color: #fff;
        }

        div.container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffe6e6;
            border: 1px solid #ffcccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php
    include('database.php');
    session_start();

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
        header("Location: index.php");
        exit();
    }

    if (isset($_GET['id'])) {
        $userID = $_SESSION['id'];
        $dataID = $_GET['id'];

        $stmt = $con->prepare("SELECT * FROM faculty_fill_data WHERE user_id = ? AND id = ?");
        $stmt->bind_param("ii", $userID, $dataID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            echo "<div class='container'>";
            echo "<h1>View Data</h1>";

            echo "<table>";
            echo "<tr><th>Field</th><th>Value</th></tr>";
            echo "<tr><td>Faculty Name</td><td>" . htmlspecialchars($row["name"]) . "</td></tr>";
            echo "<tr><td>Department</td><td>" . htmlspecialchars($row["department"]) . "</td></tr>";
            echo "<tr><td>Alloted School</td><td>" . htmlspecialchars($row["schools"]) . "</td></tr>";
            echo "<tr><td>Date</td><td>" . htmlspecialchars($row["date"]) . "</td></tr>";
            echo "<tr><td>Principal Name</td><td>" . htmlspecialchars($row["pname"]) . "</td></tr>";
            echo "<tr><td>Principal Contact No.</td><td>" . htmlspecialchars($row["pcont"]) . "</td></tr>";
            echo "<tr><td>TGT Name</td><td>" . htmlspecialchars($row["tgtname"]) . "</td></tr>";
            echo "<tr><td>TGT Contact No.</td><td>" . htmlspecialchars($row["tgtcont"]) . "</td></tr>";
            echo "<tr><td>PGT Name</td><td>" . htmlspecialchars($row["pgtname"]) . "</td></tr>";
            echo "<tr><td>PGT Contact No.</td><td>" . htmlspecialchars($row["pgtcont"]) . "</td></tr>";
            echo "<tr><td>School Status</td><td>" . htmlspecialchars($row["school_status"]) . "</td></tr>";
            echo "<tr><td>10th Strength</td><td>" . htmlspecialchars($row["ten"]) . "</td></tr>";
            echo "<tr><td>12th Strength</td><td>" . htmlspecialchars($row["twelve"]) . "</td></tr>";
            echo "<tr><td>Topic Covered</td><td>" . htmlspecialchars($row["topic_covered"]) . "</td></tr>";
            echo "<tr><td>Visit Remark</td><td>" . htmlspecialchars($row["visit_remark"]) . "</td></tr>";
            echo "<tr><td>Data Collected</td><td>" . htmlspecialchars($row["data_collected"]) . "</td></tr>";
            echo "</table>";

            echo "<a href='my_submissions.php'>Back to Data</a>";
            echo "</div>";
        } else {
            echo "<div class='container'>";
            echo "<h1>Data not found</h1>";
            echo "<a href='my_submissions.php'>Back to Data</a>";
            echo "</div>";
        }
    } else {
        echo "<div class='container'>";
        echo "<h1>Invalid data ID</h1>";
        echo "<a href='my_submissions.php'>Back to Data</a>";
        echo "</div>";
    }
    ?>
</body>

</html>
