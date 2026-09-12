<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Collection Distribution</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Data Collection Distribution</h1>

    <canvas id="dataCollectionPieChart" width="400" height="400"></canvas>

    <?php
    include('database.php'); // Include the database connection

    // Query to retrieve the count of each data_collected value from the faculty_fill_data table
    $sql = "SELECT data_collected, COUNT(*) as count FROM faculty_fill_data GROUP BY data_collected";
    $result = $con->query($sql);
    ?>

    <script>
        <?php
        // Fetch data from MySQL and prepare it for the chart
        $labels = array();
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['data_collected'];
            $data[] = $row['count'];
        }
        ?>

        // Get the canvas element and its 2d context
        var ctx = document.getElementById('dataCollectionPieChart').getContext('2d');

        // Define the data for the pie chart
        var data = {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                data: <?php echo json_encode($data); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    // Add more colors as needed
                ],
            }],
        };

        // Create a pie chart
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: data,
        });
    </script>

    <!-- Add a link to go back to the previous page if needed -->
    <a href="display_data.php">Go Back</a>
</body>
</html>
