<?php
	include("auth.php");
	include("../config.php");
	$maintID=$_SESSION['maint_id'];

	if (isset($_POST['submit'])) {
		$currentPassword=md5($_POST['currentPassword']);
		$confirmPassword=md5($_POST['confirmPassword']);
		$newPassword=md5($_POST['newPassword']);
		if ($currentPassword!=""&&$confirmPassword!=""&&$confirmPassword==$newPassword) {
			$stmt =mysqli_query($conn, "SELECT password FROM user WHERE username='$maintID'");
			while($row=mysqli_fetch_array($stmt)){
				if ($currentPassword==$row['password']) {
					mysqli_query($conn, "UPDATE user SET password='$confirmPassword' WHERE username='$maintID'");
					$affectedRows = mysqli_affected_rows($conn);
					if($affectedRows >= 1){
						echo '<script>alert("Successfully changed password");
							  location = "index.php";
							  </script>';
					}else{
						echo '<script>alert("Failed to changed password");</script>';
					}
				}else{
						echo '<script>alert("Wrong current password. Failed to changed password.");</script>';

				}
			}
		}else{
			echo '<script>alert("New Password does not match. Failed to changed password.");</script>';
		}
		echo "<meta http-equiv='refresh' content='0'>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Change Password | Maintenance Team | UReCo</title>

	<script type="text/javascript">

        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_act').addClass('active');
           $('#nav_act_app').addClass('active');

        });
        var check = function() {
			if (document.getElementById('newPassword').value == document.getElementById('confirmPassword').value) {
				document.getElementById('message').style.color = 'green';
				document.getElementById('message').innerHTML = 'matching';
			} else {
				document.getElementById('message').style.color = 'red';
				document.getElementById('message').innerHTML = 'not matching';
			}
		}
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<form action="changePassword.php" name="change_pswd" method="POST">
		<div class="py-4">
			<div class="d-flex flex-column " id="content">
				<nav aria-label="breadcrumb">
				  	<ol class="breadcrumb">
				    	<li class="breadcrumb-item">Profile</li>
				    	<li class="breadcrumb-item active" aria-current="page">Change Password</li>
				  	</ol>
				</nav>
				<div class="d-flex">
					<div class="p-2">
						<h3>Change Password</h3>
					</div>
					<div class="p-2">
						<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='profile.php'">Back</button>
					</div>
				</div>
					
				<div class="rounded p-4 mb-3 bg-color">
	          		<div class="container">
		              <div class="row mb-3">
		              	  <label for="currentPassword" class="col-sm-3 form-label">Current Password</label>
		                  <div class="col-sm-4">
		                      <input type="password" class="form-control" name="currentPassword" id="currentPassword" placeholder="Current Password" required>
		                  </div>
	                  </div>
	                  <div class="row mb-3">
		              	  <label for="newPassword" class="col-sm-3 form-label">New Password</label>
		                  <div class="col-sm-4">
		                      <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="New Password" required onkeyup="check()">
		                  </div>
	                  </div>
	                  <div class="row mb-3">
		              	  <label for="confirmPassword" class="col-sm-3 form-label">Confirm Password</label>
		                  <div class="col-sm-4">
		                      <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required onkeyup="check()"><span id='message'></span>
		                  </div>
	                  </div>
			 	 </div>
			  </div>
	  	</div>
	  	<input type="submit" name="submit" class="btn btn-primary" id="submit-btn" onclick="return confirm('Are you sure you want to change password?');" value="Submit">
	</div><!-- py-4 -->
  </form>            
	<!--Container Main end-->
</body>
</html>