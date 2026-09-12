<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

include('database.php');

if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($con, $_POST['name']);
   $department = mysqli_real_escape_string($con, $_POST['department']);
   $role = mysqli_real_escape_string($con, $_POST['role']);
   $username = mysqli_real_escape_string($con, $_POST['username']);
   $pass = mysqli_real_escape_string($con, $_POST['password']);
   $cpass = mysqli_real_escape_string($con, $_POST['cpassword']);

   $select = mysqli_prepare($con, "SELECT * FROM usersss WHERE username = ?");
   mysqli_stmt_bind_param($select, "s", $username);
   mysqli_stmt_execute($select);
   mysqli_stmt_store_result($select);
   $count = mysqli_stmt_num_rows($select);

   if($count > 0){
      $message[] = 'Email already exists'; 
   }else{
      if($pass != $cpass){
         $message[] = 'Confirm password does not match!';
      }else{
         $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
         $query = mysqli_prepare($con, "INSERT INTO usersss(name, department, role, username, password) VALUES (?, ?, ?, ?, ?)");
         mysqli_stmt_bind_param($query, "sssss", $name, $department, $role, $username, $hashedPass);
         
         if(mysqli_stmt_execute($query)){
            $message[] = 'Registered successfully!';
           
            
            header('location:login.php');
         }else{
            $message[] = 'Registration failed!';
         }
      }
   }
}

?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Register | EduNotesHub</title>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2268170979958753"
     crossorigin="anonymous"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'><link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="css/style.css">
  <style>
  label {
    font-weight: 600;
    color: #666;
}
body {
  background: #f1f1f1;
  background:url(../images/bg-hero.png)no-repeat fixed 50%;
}
.box8{
  box-shadow: 0px 0px 5px 1px #999;
}
.mx-t3{
  margin-top: -3rem;
}

      </style>
  </style>
</head>
<body>
<!-- partial:index.partial.html -->
<div class="container mt-2">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="row jumbotron box8">
      <div class="col-sm-12 mx-t4 mb-4">
           <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
       <h2 class="text-center text-info">Register Now</h2>
        
      </div>
      <div class="col-sm-6 form-group">
        <label for="name-f">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name." required>
      </div>
     
      <div class="col-sm-6 form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="username" id="email" placeholder="Enter your email."  pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required>
      </div>
 <div class="col-sm-6 form-group">
        <label for="sex">Department</label>
        <select id="department" name="department" class="form-control browser-default custom-select">
          <option value="ZOOLOGY DEPTT.">ZOOLOGY DEPTT.</option>
          <option value="BOTANY DEPTT.">BOTANY DEPTT.</option>
          <option value="BIOTECH.">BIOTECH.</option>
		  <option value="CHEMISTRY DEPTT.">CHEMISTRY DEPTT.</option>
		  <option value="MATHS DEPTT.">MATHS DEPTT.</option>
		  <option value="PHYSICS DEPTT.">PHYSICS DEPTT.</option>
		  <option value="HOME  SC. DEPTT.">HOME  SC. DEPTT.</option>
		   <option value="EDUCATION DEPTT.">EDUCATION DEPTT.</option>
		    <option value="MANAGEMENT">MANAGEMENT</option>
			<option value="COMPUTER">COMPUTER</option>
			<option value="STAFF MEMBERS">STAFF MEMBERS</option>
        </select>
      </div>
      <div class="col-sm-6 form-group">
        <label for="sex">Role</label>
        <select id="role" name="role" class="form-control browser-default custom-select">
          <option value="admin">admin</option>
          <option value="user">user</option>
        </select>
      </div>
    
      
      <div class="col-sm-6 form-group">
        <label for="pass">Password</label>
        <input type="Password" name="password" class="form-control" id="password" placeholder="Enter your password." required>
      </div>
      <div class="col-sm-6 form-group">
        <label for="pass2">Confirm Password</label>
        <input type="Password" name="cpassword" id="myInput" class="form-control" id="cpassword" placeholder="Re-enter your password." required>
      </div>

      <div class="col-sm-6 form-group mb-0">
         <input type="submit" name="submit" value="register now" class="btn">
          
      </div>
<br>
      <div class="col-sm-6 form-group">
          <br>
                <p>already have an account? <a href="login.php">login now</a></p>
      </div>
    </div>
  </form>
  
</div>

<!-- partial -->
  <script>
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
</body>
</html>
