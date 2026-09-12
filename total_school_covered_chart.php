<!DOCTYPE html>
<html lang="en">
<head>
    <title>Schools Distribution</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Schools Distribution</h1>

    <canvas id="schoolsBarChart" width="400" height="400"></canvas>

    <?php
    include('database.php'); // Include the database connection

    // Query to retrieve the count of each school from the faculty_fill_data table
    $sql = "SELECT schools, COUNT(*) as count FROM faculty_fill_data GROUP BY schools";
    $result = $con->query($sql);
    ?>

    <script>
        <?php
        // Fetch data from MySQL and prepare it for the chart
        $labels = array();
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['schools'];
            $data[] = $row['count'];
        }
        ?>

        // Get the canvas element and its 2d context
        var ctx = document.getElementById('schoolsBarChart').getContext('2d');

        // Define the data for the bar chart
        var data = {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Number of Schools',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.8)', // Adjust the color as needed
                borderWidth: 1,
            }],
        };

        // Create a bar chart
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    </script>

    <!-- Add a link to go back to the previous page if needed -->
    <a href="display_data.php">Go Back</a>
</body>
</html>
