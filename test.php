<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Include the database connection
include('database.php');

// Get the total number of users with the role 'user'
$sqlTotalUsers = "SELECT COUNT(*) as totalUsers FROM usersss WHERE role = 'user'";
$resultTotalUsers = $con->query($sqlTotalUsers);
$rowTotalUsers = $resultTotalUsers->fetch_assoc();
$totalUsers = $rowTotalUsers['totalUsers'];

// Get the count of users with 'Pending' status
$sqlPendingUsers = "SELECT COUNT(*) as pendingUsers FROM faculty_data WHERE status = 'Pending'";
$resultPendingUsers = $con->query($sqlPendingUsers);
$rowPendingUsers = $resultPendingUsers->fetch_assoc();
$pendingUsers = $rowPendingUsers['pendingUsers'];

// Get the count of users with 'Completed' status
$sqlCompletedUsers = "SELECT COUNT(*) as completedUsers FROM faculty_data WHERE status = 'Completed'";
$resultCompletedUsers = $con->query($sqlCompletedUsers);
$rowCompletedUsers = $resultCompletedUsers->fetch_assoc();
$completedUsers = $rowCompletedUsers['completedUsers'];

// Get the count of records in the faculty_data table for given allotments
$sqlGivenAllotments = "SELECT COUNT(*) as givenAllotments FROM faculty_data";
$resultGivenAllotments = $con->query($sqlGivenAllotments);
$rowGivenAllotments = $resultGivenAllotments->fetch_assoc();
$givenAllotments = $rowGivenAllotments['givenAllotments'];

// Close the database connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="your-styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }

        .dashboard {
            text-align: center;
            margin: 20px;
        }

        .chart-container {
            width: 80%;
            margin: 20px auto;
        }
    </style>
    <title>Dashboard with Charts</title>
</head>

<body>
    <div class="dashboard">
        <h1>Dashboard with Charts</h1>
        <div class="chart-container">
            <canvas id="userChart"></canvas>
        </div>
    </div>

    <script>
        // Data for the charts
        var userChartCanvas = document.getElementById('userChart').getContext('2d');
        var userChartData = {
            labels: ['Total Users', 'Pending Users', 'Completed Users', 'Given Allotments'],
            datasets: [{
                label: 'User Statistics',
                data: [<?php echo $totalUsers; ?>, <?php echo $pendingUsers; ?>, <?php echo $completedUsers; ?>, <?php echo $givenAllotments; ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(54, 162, 235, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Chart options
        var userChartOptions = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Create the charts
        var userChart = new Chart(userChartCanvas, {
            type: 'bar',
            data: userChartData,
            options: userChartOptions
        });
    </script>
</body>

</html>
