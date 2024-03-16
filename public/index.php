
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
   <title>Login | UReCo</title>
   <link rel="stylesheet" type="text/css" href="../css/login.css">
   <!-- favicon -->
   <link rel="shortcut icon" type="image/png" href="../asset/favicon-32x32.png">   
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body style="background-image: url(../asset/satriablurred.jpg);background-size:cover">
   <div class="container">
      <header>UReCo</header>
      <h2>Login</h2>
      <form method="POST" name="login" action="index.php">
         <div class="input-field">
            <input type="text" name="username" maxlength="10" required>
            <label>Username</label>
         </div>
         <div class="input-field">
            <input type="password" name="password" required>
            <label>Password</label>
         </div>
         <div>
               <a href="forgetPass.php" class="pass-link">Forgot password?</a>
         </div>
         <div class="button">
            <div class="inner"></div>
            <button type="submit" name="login" >LOGIN</button>
         </div>
      </form>
   </div>
</body>
</html>

<?php
   // connect to db
   require_once 'config.php';
   // creates a session or resumes the current one
   session_start();
   // if submit button is clicked
   if (isset($_POST['login'])){
      // assign variables that post from login form
      $id  = $_POST['username'];
      $pwd = md5($_POST['password']);
      // prepare SQL query
      //$sql = "SELECT stud_name, matric_num, password, student.room_bed_id as room, room_bed.block_id as bid, block.area_id as aid, block_name, area_name FROM student JOIN room_bed ON student.room_bed_id = room_bed.room_bed_id JOIN block ON room_bed.block_id=block.block_id JOIN area ON block.area_id=area.area_id WHERE matric_num = '$id'";
      $sql = "SELECT * FROM user WHERE username = '$id'";
      // connect query to db
      $result = mysqli_query($conn, $sql);
      // store number of row of the result returned
      $row  = mysqli_num_rows($result);
      // store result of SQL query
      $roww    = mysqli_fetch_assoc($result);
      $accType = $roww['accType'];
      $dbPass = $roww['password'];
      //check account type
      if(($accType == 1)){
         //prepare SQL query for student
         $sqls = "SELECT studName, roomID, block.blockID, block.blockName, college.collegeID, college.collegeName, profilePic FROM student JOIN college ON student.collegeID = college.collegeID JOIN block ON student.blockID = block.blockID WHERE matrixNo = '$id'";
         $results = mysqli_query($conn, $sqls);
         $rows = mysqli_fetch_assoc($results);
         //assign data to variables
         $stud_name = $rows['studName'];
         $room_bed_id = $rows['roomID'];
         $block_id = $rows['blockID'];
         $block_name = $rows['blockName'];
         $college_id = $rows['collegeID'];
         $college_name = $rows['collegeName'];
		 $profile_pic = $rows['profilePic'];
         
         // check number of row of the result returned
         // return 0 row: the entered staff_id does not match database 
         if ($row == 0) {
         // show alert then redirect to login form
         echo "   <script>
                  alert('Invalid Username/Password.')
                  location = 'index.php'
               </script>";
         exit();
         }
         // staff_id matched but password does not match
         else if($dbPass != $pwd){
            // show alert then redirect to login form
            echo "   <script>
                     alert('Invalid Username/Password.');
                     location = 'index.php'
                  </script>";
            exit();
         }
         // both staff_id & password matched
         else{
            // assign variable to session for later use
            $_SESSION['matrixNo'] = $id;
            $_SESSION['studName'] = $stud_name;
            $_SESSION['roomID'] = $room_bed_id; 
            $_SESSION['blockID'] = $block_id;
            $_SESSION['blockName'] = $block_name;
            $_SESSION['collegeID'] = $college_id;     
            $_SESSION['collegeName'] = $college_name;
			$_SESSION['profilePic'] = $profile_pic;
            // redirect to home page
            header("location: student/index.php");
            exit();
         }; 
      }
      else if($accType == 2){
         $sqlStaff = "SELECT staff.*, college.collegeName, block.blockName FROM staff JOIN college ON staff.collegeID = college.collegeID JOIN block ON staff.blockID = block.blockID WHERE staffID = '$id'";
         $resultStaff = mysqli_query($conn, $sqlStaff);
         $rowStaff = mysqli_fetch_assoc($resultStaff);
         $staff_name = $rowStaff['staffName'];
         $block_id = $rowStaff['blockID'];
         $block_name = $rowStaff['blockName'];
         $college_id = $rowStaff['collegeID'];
         $college_name = $rowStaff['collegeName'];
		 $profile_pic = $rowStaff['profilePic'];
         
         if ($row == 0) {
         // show alert then redirect to login form
         echo "   <script>
                  alert('Invalid Username/Password')
                  location = 'index.php'
               </script>";
         exit();
         }
         // staff_id matched but password does not match
         else if($dbPass != $pwd){
            // show alert then redirect to login form
            echo "   <script>
                     alert('Invalid Username/Password.');
                     location = 'index.php'
                  </script>";
            exit();
         }
         // both staff_id & password matched
         else{
            // assign variable to session for later use
            $_SESSION['staff_id']   = $id;
            $_SESSION['staff_name'] = $staff_name;
            $_SESSION['block_id']   = $block_id;
            $_SESSION['block_name'] = $block_name;
            $_SESSION['college_id'] = $college_id;
            $_SESSION['college_name'] = $college_name;
			$_SESSION['profilePic'] = $profile_pic;

            // redirect to home page
            header("location: staff/index.php");
            exit();
         };
      }
      else if($accType == 3){
         $sqlMaint = "SELECT maintenance.*, college.collegeName, block.blockName FROM maintenance JOIN college ON maintenance.collegeID = college.collegeID JOIN block ON maintenance.blockID = block.blockID WHERE maintID = '$id'";
         $resultMaint = mysqli_query($conn, $sqlMaint);
         $rowMaint = mysqli_fetch_assoc($resultMaint);
         $maint_name = $rowMaint['maintName'];
         $maint_id = $rowMaint['maintID'];
         $block_id   = $rowMaint['blockID'];
         $block_name = $rowMaint['blockName'];
         $college_id = $rowMaint['collegeID'];
         $college_name  = $rowMaint['collegeName'];
		 $profile_pic = $rowMaint['profilePic'];
         
         if ($row == 0) {
         // show alert then redirect to login form
         echo "   <script>
                  alert('Invalid Username/Password')
                  location = 'index.php'
               </script>";
         exit();
         }
         // staff_id matched but password does not match
         else if($dbPass != $pwd){
            // show alert then redirect to login form
            echo "   <script>
                     alert('Invalid Username/Password.');
                     location = 'index.php'
                  </script>";
            exit();
         }
         // both staff_id & password matched
         else{
            // assign variable to session for later use
            $_SESSION['maint_id']   = $id;
            $_SESSION['maint_name'] = $maint_name;
            $_SESSION['block_id']   = $block_id;
            $_SESSION['block_name'] = $block_name;
            $_SESSION['college_id'] = $college_id;
            $_SESSION['college_name'] = $college_name;
			$_SESSION['profilePic'] = $profile_pic;

            // redirect to home page
            header("location: maint/index.php");
            exit();
         };
      }
      else{
         if($dbPass != $pwd){
            echo "   <script>
                     alert('Invalid Username/Password.');
                     location = 'index.php'
                  </script>";
            exit();
         }
         else{
            $_SESSION['username'] = $id;
            header("location: admin/index.php");
            exit();
         }
      }
   }
?>