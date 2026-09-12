  <?php
    session_start();
    include('database.php');

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
        header("Location: index.php"); // Redirect to login page if not logged in or not a user
        exit();
    }

    $userID = $_SESSION['id'];
	    $id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission and database insertion
    $user_id = $_SESSION['id'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $target = $_POST['target'];
    $tsdate = $_POST['tsdate'];
    $tedate = $_POST['tedate'];
    $schools = implode(', ', $_POST['schools']);
    $date = $_POST['date'];
    $pname = $_POST['pname'];
    $pcont = $_POST['pcont'];
    $tgtname = $_POST['tgtname'];
    $tgtcont = $_POST['tgtcont'];
    $pgtname = $_POST['pgtname'];
    $pgtcont = $_POST['pgtcont'];
    $school_status = $_POST['school_status'];
    $ten = $_POST['ten'];
    $twelve = $_POST['twelve'];
    $topic_covered = $_POST['topic_covered'];
    $visit_remark = $_POST['visit_remark'];
    $data_collected = $_POST['data_collected'];

    // Insert data into the database using a prepared statement
    $sql = "INSERT INTO faculty_fill_data (user_id, name, department, target, tsdate, tedate, schools, date, pname, pcont, tgtname, tgtcont, pgtname, pgtcont, school_status, ten, twelve, topic_covered, visit_remark, data_collected) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param(
        "isssssssssssssssssss",
        $user_id, $name, $department, $target, $tsdate, $tedate, $schools, $date,
        $pname, $pcont, $tgtname, $tgtcont, $pgtname, $pgtcont, $school_status,
        $ten, $twelve, $topic_covered, $visit_remark, $data_collected
    );

    if ($stmt->execute()) {
        // Update the status to 'completed' for the specific record_id and user_id
        $updateStmt = $con->prepare("UPDATE faculty_data SET status = 'Completed' WHERE id = ? AND user_id = ?");
        $updateStmt->bind_param("ii", $id, $user_id);
        if ($updateStmt->execute()) {
            echo "<script>alert('Data Successfully Added and Status Updated to Completed.');</script>";
        } else {
            echo "Error updating status: " . $updateStmt->error;
        }
        $updateStmt->close();
    } else {
        echo "Error: " . $stmt->error;
    }
    $con->close();
}
	?>
<!DOCTYPE html>
<!-- Website - www.codingnepalweb.com -->
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style1.css">
  <!-- Boxicons CDN Link -->
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .form-group {
      margin: 15px;
    }

    .head {
      position: relative;
      font-size: 30px;
      font-weight: 600;
      color: #333;
      margin: 15px;
      align-items: center;
    }



    .head::before {
      content: "";
      position: relative;
      left: 0;
      bottom: -2px;
      height: 3px;
      width: 50px;
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
        <a href="faculty_panel.php" class="active">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Faculty Panel</span>
        </a>
      </li>

      <li>
        <a href="my_submissions.php">
          <i class='bx bx-book-alt'></i>
          <span class="links_name">Finished Task</span>
        </a>
      </li>
      <li>
        <a href="pending.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Pending Tasks</span>
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
        <span class="dashboard">Faculty Panel</span>
      </div>
    </nav>

    <div class="home-content">
<?php
        include 'database.php'; // Include the database connection

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // Query to fetch a specific user's data
            $sql = "SELECT * FROM faculty_data WHERE id = $id";
            $result = $con->query($sql);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
        ?>
      <form method="POST" action="">
        <div class="form-group">

          <div class="row">
		  
		  <div class="col-md-3">
              <div class="form-group">
                <label for="name">User Id:</label>
                <input type="text" id="name" name="id" value="<?php echo htmlspecialchars($row["user_id"]); ?>" class="form-control" readonly>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="name">Faculty Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row["name"]); ?>" class="form-control" readonly>
              </div> 
            </div>

            

            <div class="col-md-3">
              <div class="form-group">
                <label for="name">Department:</label>
               <input type="text" id="department" name="department" value="<?php echo htmlspecialchars($row['department']); ?>"class="form-control" readonly>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="name">Target:</label>
                <input type="text" id="target" name="target" value="<?php echo htmlspecialchars($row['target']); ?>"class="form-control" readonly>
              </div>
            </div>
			  <div class="col-md-3">
              <div class="form-group">
                <label for="name">Target Start Date:</label>
                <input type="text" id="tsdate" value="<?php echo htmlspecialchars($row['tsdate']); ?> "name="tsdate" class="form-control" readonly>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="email">Target End Date:</label>
                <input type="text" id="tedate" name="tedate" value="<?php echo htmlspecialchars($row['tedate']); ?>" class="form-control"readonly>
              </div>
            </div>

			
          </div>

          <div class="row">

 <div class="col-md-6">
              <div class="form-group">
                <label for="alloted"> Select one of Alloted Schools:</label>
                <Select name="schools[]" multiple class="form-control">
 <?php
                      // Query to fetch the list of alloted schools
                      $allotedSql = "SELECT schools FROM faculty_data WHERE id = $id";
                      $allotedResult = $con->query($allotedSql);
                      if ($allotedResult->num_rows == 1) {
                        $allotedRow = $allotedResult->fetch_assoc();
                        $allotedSchools = explode(',', $allotedRow['schools']);
                        foreach ($allotedSchools as $school) {
                          $school = trim($school);
                          echo '<option value="' . $school . '">' . $school . '</option>';
                        }
                      } else {
                        echo '<option value="">No alloted schools</option>';
                      }
                      ?>
                </select>
              </div>
            </div>
			
			            <div class="col-md-3">
              <div class="form-group">
                <label for="name">Date:</label>
                <input type="date" id="date" name="date" class="form-control">
              </div>
            </div>

           

            <div class="col-md-3">
              <div class="form-group">
                <label for="name">Principal Name:</label>
                <input type="text" id="pname" name="pname" class="form-control">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="name">Principal's Contact No.:</label>
                <input type="text" id="pcont" name="pcont" class="form-control">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="name">TGT Teacher Name:</label>
                <input type="text" id="tgtname" name="tgtname" class="form-control">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="name">TGT Teacher's Contact No.:</label>
                <input type="text" id="tgtcont" name="tgtcont" class="form-control">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="name">PGT Teacher Name:</label>
                <input type="text" id="pgtname" name="pgtname" class="form-control">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="name">PGT Teacher's Contact No.:</label>
                <input type="text" id="pgtcont" name="pgtcont" class="form-control">
              </div>
            </div>


       
            <div class="col-md-3">
              <div class="form-group">
                <label for="name">School Status:</label>
                <Select name="school_status" class="form-control">
                    <option value="U.P. BOARD">U.P. BOARD</option>
            <option value="CBSE Board">CBSE Board</option>
            <option value="ICSE Board">ICSE Board</option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="name">No. Of 10th Students:</label>
                <input type="text" id="ten" name="ten" class="form-control">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="name">No. Of 12th Students:</label>
                <input type="text" id="twelve" name="twelve" class="form-control">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="name">Topic Covered:</label>
                <input type="text" id="topic" name="topic_covered" class="form-control">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="name">Visit Remarks:</label>
                <input type="text" id="visistremark" name="visit_remark" class="form-control">
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label for="name">Data Collected:</label>
                <Select name="data_collected" class="form-control">
                    <option value="Yes">Yes</option>
            <option value="No">No</option>
                </select>
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

  <script src="script.js"></script>
</body>

</html>