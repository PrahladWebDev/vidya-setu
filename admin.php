<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect to login page if not logged in or not an admin
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
  <title>Admin Panel</title>
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

  </style>
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">

      <span class="logo_name" style="margin-left:4px">VIDYA SETU</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="admin.php" class="active">
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
        <a href="regi_list.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Allotment</span>
        </a>
      </li>


      <li>
        <a href="add_users.php">
          <i class='bx bx-user-plus'></i>
          <span class="links_name">Add Faculty</span>
        </a>
      </li>
      <li>
        <a href="test.php">
          <i class='bx bx-bar-chart-alt-2'></i>
          <span class="links_name">Stats</span>
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

    <div class="home-content"></div>
    <div>
      <h2>Graph Of Task Complited by faculty</h2>
    </div>
    <div>
      <h2>graph of Task Panding by Faculty</h2>
    </div>
    <div>
      <h2>Total College Covered</h2>
    </div>
    <div>
      college Panding
    </div>
    <div>
      total data Colleted
      <div>
        Up
      </div>
      <div>
        CBSE
      </div>
      <div>
        ICSE
      </div>
    </div>
    <div>
      <h2>Deprtment wise School students Segregation</h2>
    </div>
    <div>Year Wise School Student Segregation</div>
    <div>
      time Series Analysi
    </div>

    <a class="nav-link" href="logout.php"><?php echo ucwords($_SESSION['username']); ?></a>

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
</body>

</html>