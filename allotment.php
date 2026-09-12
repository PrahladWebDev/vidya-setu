<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
     /* Googlefont Poppins CDN Link */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
/* style1.css */

*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

.sidebar {
    position: fixed;
    height: 100%;
    width: 240px;
    background: #FF6961; /* Light red background color */
    transition: all 0.5s ease;
}

.sidebar.active {
    width: 60px;
}

.sidebar .logo-details {
    height: 80px;
    display: flex;
    align-items: center;
}

.sidebar .logo-details i {
    font-size: 28px;
    font-weight: 500;
    color: #fff;
    min-width: 60px;
    text-align: center;
}

.sidebar .logo-details .logo_name {
    color: #fff;
    font-size: 24px;
    font-weight: 500;
}

.sidebar .nav-links {
    margin-top: 10px;
}

.sidebar .nav-links li {
    position: relative;
    list-style: none;
    height: 50px;
}

.sidebar .nav-links li a {
    height: 100%;
    width: 100%;
    display: flex;
    align-items: center;
    text-decoration: none;
    transition: all 0.4s ease;
}

.sidebar .nav-links li a.active {
    background: #FF4842; /* Darker shade of red for active */
    color: #fff;
}

.sidebar .nav-links li a:hover {
    background: #FF4842; /* Darker shade of red on hover */
    color: #fff;
}

.sidebar .nav-links li i {
    min-width: 60px;
    text-align: center;
    font-size: 18px;
    color: #fff;
}

.sidebar .nav-links li a .links_name {
    color: #fff;
    font-size: 15px;
    font-weight: 400;
    white-space: nowrap;
}

.sidebar .nav-links .log_out {
    position: absolute;
    bottom: 0;
    width: 100%;
}

.home-section {
    position: relative;
    background: #f5f5f5;
    min-height: 100vh;
    width: calc(100% - 240px);
    left: 240px;
    transition: all 0.5s ease;
}

.sidebar.active ~ .home-section {
    width: calc(100% - 60px);
    left: 60px;
}

.home-section nav {
    display: flex;
    justify-content: space-between;
    height: 80px;
    background: #fff;
    display: flex;
    align-items: center;
    position: fixed;
    width: calc(100% - 240px);
    left: 240px;
    z-index: 100;
    padding: 0 20px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    transition: all 0.5s ease;
}

.sidebar.active ~ .home-section nav {
    left: 60px;
    width: calc(100% - 60px);
}

.home-section nav .sidebar-button {
    display: flex;
    align-items: center;
    font-size: 24px;
    font-weight: 500;
}

nav .sidebar-button i {
    font-size: 35px;
    margin-right: 10px;
}

.home-section .home-content {
    position: relative;
    padding-top: 104px;
    padding-left: 10px;
    padding-right: 10px;
}

/* Responsive Media Query */
@media (max-width: 1240px) {
    .sidebar {
        width: 60px;
    }

    .sidebar.active {
        width: 220px;
    }

    .home-section {
        width: calc(100% - 60px);
        left: 60px;
    }

    .sidebar.active ~ .home-section {
        overflow: hidden;
        left: 220px;
    }

    .home-section nav {
        width: calc(100% - 60px);
        left: 60px;
    }

    .sidebar.active ~ .home-section nav {
        width: calc(100% - 220px);
        left: 220px;
    }
}

@media (max-width: 400px) {
    .sidebar {
        width: 0;
    }

    .sidebar.active {
        width: 60px;
    }

    .home-section {
        width: 100%;
        left: 0;
    }

    .sidebar.active ~ .home-section {
        left: 60px;
        width: calc(100% - 60px);
    }

    .home-section nav {
        width: 100%;
        left: 0;
    }

    .sidebar.active ~ .home-section nav {
        left: 60px;
        width: calc(100% - 60px);
    }
}

    .form-group {
      margin: 15px;
    }

    .head {
      position: relative;
      font-size: 30px;
      font-weight: 600;
      color: #333;
      margin: 15px;
    }

    .head::before {
      content: "";
      position: absolute;
      left: 0;
      bottom: -2px;
      height: 3px;
      width: 147px;
      border-radius: 8px;
      background-color: #4070f4;
    }

    .btn {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 45px;
      max-width: 200px;
      width: 100%;
      border: none;
      outline: none;
      color: #fff;
      border-radius: 5px;
      margin: 25px 10px;
      background-color: #4070f4;
      transition: all 0.3s linear;
      cursor: pointer;
    }

    #photo-upload {
      width: 200px;
      height: 200px;
    }

    #photo-preview {
      width: 200px;
      height: 200px;
      border: 1px solid black;
      margin-top: 10px;
    }
	
  </style>
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">

      <span class="logo_name" style="margin-left:4px">VIDYA SETU</span>
    </div>
    <ul class="nav-links">
    <li>
        <a href="admin.php" >
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Admin Dasboard</span>
        </a>
      </li>
      <li>
        <a href="admin_data_report.php">
          <i class='bx bx-book-alt'></i>
          <span class="links_name">Data Report</span>
        </a>
      </li>
      <li>
        <a href="allotment.php" class="active" >
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Allotment</span>
        </a>
      </li>
     
     
      <li>
        <a href="search-vehicle.php">
          <i class='bx bx-search'></i>
          <span class="links_name">Search</span>
        </a>
      </li>
      <li class="log_out">
        <a href="logout.php">
          <i class='bx bx-log-out bx-fade-left-hover'></i>
          <span class="links_name">Log out</span>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Vidya Setu Workshop Details</span>
      </div>
    </nav>

    <div class="home-content">
	 <?php
        include 'database.php'; // Include the database connection

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // Query to fetch a specific user's data
            $stmt = $con->prepare("SELECT * FROM usersss WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
        ?>
      <form action="" method="POST">
        <div class="form-group">
          <label for="photo">Choose Faculty Photo:</label>
          <input type="file" id="photo" name="photo" class="form-control-file" style="width: auto;">
		     <input type="hidden" name="user_id" value="<?php echo $id; ?>">

          <div id="photo-preview">
		  <img src="bg-login.png" width="200" height="200">
		  </div>


          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="name">Faculty Stream:</label>
               <input type="text" id="facstream" name="facstream" value="<?php  echo $row['department'];?>" class="form-control"readonly>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="name">Faculty Name:</label>
               <input type="text" id="facname" name="facname" value="<?php  echo $row['name'];?>" class="form-control" readonly>
              </div>
            </div>
<?php
// Retrieve regions from the database (reuses the shared $con connection)
$region_query = "SELECT * FROM regions";
$region_result = $con->query($region_query);
?>
            <div class="col-md-4">
              <div class="form-group">
                <label for="name">College Region:</label>
                <Select class="form-control" name="region" id="region">
				<option value="">--Select Region--</option>
                  <?php
    while ($row = $region_result->fetch_assoc()) {
        echo "<option value='" . $row['region_id'] . "'>" . $row['region_name'] . "</option>";
    }
    ?>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="name" >College Name:</label>
                <Select class="form-control" name="schools[]" id="school" multiple onchange="updateTarget()"> 
				 </select>
              </div>
            </div>
			<div class="col-md-6">
              <div class="form-group">
                <label for="name">Targeted schools:</label>
             <select id="selectedSchools" name="selectedSchools[]" class="form-control" multiple>
			 </select>
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="name">Target:</label>
                <input type="text" id="target" name="target" class="form-control">
              </div>
            </div>
  

            <div class="col-md-4">
              <div class="form-group">
                <label for="name">Target Start Date:</label>
                <input type="date" id="tsdate" name="tsdate" class="form-control">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="email">Target End Date:</label>
                <input type="date" id="tedate" name="tedate" class="form-control">
              </div>
            </div>
			 <div class="col-md-4">
              <div class="form-group">
                <input type="hidden" id="hidden" name="status" value="Pending" class="form-control">
              </div>
            </div>

          </div>
        </div>
        <input type="submit" value="Submit" class="btn">
      </form>

        <?php
            } else {
                echo "User not found.";
            }
        } else {
            echo "Invalid user ID.";
        }

        $con->close();
        ?>
    </div>

  </section>
  <script>
function updateTarget() {
    var selectedSchools = document.getElementById('school').selectedOptions;
    var selectedSchoolsDropdown = document.getElementById('selectedSchools');
    var target = document.getElementById('target');

    // Remove existing options in the selectedSchoolsDropdown
    while (selectedSchoolsDropdown.options.length > 0) {
        selectedSchoolsDropdown.remove(0);
    }

    // Initialize an array to store selected school names
    var selectedSchoolNames = [];

    // Loop through selected options to collect names
    for (var i = 0; i < selectedSchools.length; i++) {
        selectedSchoolNames.push(selectedSchools[i].text);

        // Create new options for the selectedSchoolsDropdown
        var option = document.createElement("option");
        option.text = selectedSchools[i].text;
        option.value = selectedSchools[i].value;
        selectedSchoolsDropdown.add(option);
    }

    // Update the "Target" textbox with the count of selected schools
    target.value = selectedSchools.length;
}
</script>


  <script>
    document.getElementById('region').addEventListener('change', function () {
        var regionId = this.value;
        var schoolDropdown = document.getElementById('school');

        // Clear existing options
        schoolDropdown.innerHTML = "<option value=''>--Select School--</option>";

        if (regionId) {
            // Fetch schools based on the selected region (AJAX call to get_schools.php)
            fetchSchools(regionId);
        }
    });

    function fetchSchools(regionId) {
        var schoolDropdown = document.getElementById('school');
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_schools.php?region_id=' + regionId, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                var schools = JSON.parse(xhr.responseText);

                schools.forEach(function (school) {
                    schoolDropdown.innerHTML += "<option value='" + school.school_name + "'>" + school.school_name + "</option>";
                });
            }
        };

        xhr.send();
    }
</script>
  <script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function() {
      sidebar.classList.toggle("active");
      if (sidebar.classList.contains("active")) {
        sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
      } else
        sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    }
  </script>

  <script>
    document.getElementById('photo').addEventListener('change', function(e) {
      var file = e.target.files[0];
      var reader = new FileReader();

      reader.onload = function(e) {
        var imgSrc = e.target.result;
        document.getElementById('photo-preview').innerHTML = '<img src="' + imgSrc + '" width="200" height="200">';
      }

      reader.readAsDataURL(file);
    });
  </script>
</body>

</html>
<?php
// Include the database connection
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID from the form
    $loggedInUserId = $_POST['user_id'];

    // Get the rest of the form data
     // Temporary path to uploaded photo
    $department = $_POST['facstream'];
    $name = $_POST['facname'];
    $regionId = $_POST['region'];
    $schools = implode(', ', $_POST['schools']);
    $target = $_POST['target'];
    $tsdate = $_POST['tsdate'];
    $tedate = $_POST['tedate'];
	  $status = $_POST['status'];

    // Move the uploaded photo to a permanent location
   
    // Insert the form data into the MySQL table, including the user ID
    $sql = "INSERT INTO faculty_data (user_id,department, name, region_id, schools, target, tsdate, tedate,status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("issisisss", $loggedInUserId, $department, $name, $regionId, $schools, $target, $tsdate, $tedate,$status);

    if ($stmt->execute()) {
		echo "<script>
alert('Allotment Successfully Added');
</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
} else {
    echo "";
}
?>
