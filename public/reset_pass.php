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
      <h2>Reset Password</h2>
      <form method="POST" name="login" action="reset_pass.php?id=<?php echo $_GET['id']?>">
         <div class="input-field">
            <input class="pswrd" type="password" name="password" required>
            <!-- <span class="show"><i class="fas fa-eye"></i></span> -->
            <label>Password</label>
         </div>
         <div class="input-field">
            <input class="pswrd" type="password" name="cpassword" required>
            <!-- <span class="show"><i class="fas fa-eye"></i></span> -->
            <label>Confirm Password</label>
         </div>
         <div class="button">
            <div class="inner"></div>
            <button type="submit" name="reset">RESET</button>
         </div>
      </form>
   </div>

   <script>
      var input = document.querySelector('.pswrd');
      var show = document.querySelector('.show');
      show.addEventListener('click', active);
      function active(){
        if(input.type === "password"){
          input.type = "text";
          show.style.color = "#1DA1F2";
          show.textContent = "HIDE";
        }else{
          input.type = "password";
          show.textContent = "SHOW";
          show.style.color = "#111";
        }
      }
   </script>
</body>
</html>

<?php
	// connect to db
	require_once 'config.php';
	// creates a session or resumes the current one
	session_start();

	// if submit button is clicked
	if (isset($_POST['reset'])){
		// assign variables that post from login form
		$id  = $_GET['id'];
		$pwd = md5($_POST['password']);
		$cpwd = md5($_POST['cpassword']);
		
		if($pwd != $cpwd){
			echo 	"<script>
						alert('Password must be same')
						location = 'reset_pass.php?id=".$id."'
					</script>";
			exit();
		}
		
		// prepare SQL query
		$sql = "SELECT password FROM user WHERE username = '$id'";
		// connect query to db
		$result = mysqli_query($conn, $sql);
		// store number of row of the result returned
		$row 	= mysqli_num_rows($result);
		// store result of SQL query
		$roww 	= mysqli_fetch_assoc($result);
		$dbPass = $roww['password'];
		
		if($row ==0){
			echo "	<script>
						alert('Invalid Username')
						location = 'reset_pass.php?id=".$id."'
					</script>";
			exit();
		}
		if($pwd == $dbPass){
			echo "	<script>
						alert('Same to old password!')
						location = 'reset_pass.php?id=".$id."'
					</script>";
			exit();
		}
		//prepare SQL query for student
		$sqls = "UPDATE user set  password = '$pwd' WHERE username = '$id'";
		$results = mysqli_query($conn, $sqls);
		if(!$result)
			echo "Error updating record: " . mysqli_error($conn);
		else{
			echo "	<script>
						alert('Password reset successful!')
						location = 'index.php'
					</script>";
			exit();
		};	
	}
		
?>