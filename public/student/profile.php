<?php
	include("auth.php");
	include("../config.php");
	$matrixNo=$_SESSION['matrixNo'];

	if (isset($_POST['submit'])) {
		$studName=$_POST['studName'];
		$gender=$_POST['gender'];
		$studTel=$_POST['studTel'];
		$studEmail=$_POST['studEmail'];
		$year=$_POST['year'];
		$faculty=$_POST['faculty'];
		$file = $_FILES['file']['name'];
		
		if($file == "")
			$fPath = $_SESSION['profilePic'];
		else{
			$path = "../uploaded_files/profile/".$matrixNo;
			if (!file_exists($path)) {
				mkdir($path);
			}
				
			$upload_file = date("YmdHis").'_'.$_FILES['file']['name'];// correct file & filename into db
			$fPath = $path.'/'.$upload_file;
			move_uploaded_file($_FILES["file"]["tmp_name"], $path.'/'.$upload_file); //current file, datetime_name into $path
		}

		if($studName!=""&&$gender!=""&&$studTel!=""&&$studEmail!=""&&$year!=""&&$faculty!=""&&$fPath!=""){
			
			$result = mysqli_query($conn,"UPDATE student SET studName='$studName', gender='$gender', studTel='$studTel', studEmail='$studEmail', year='$year', faculty='$faculty', profilePic='$fPath' WHERE matrixNo='$matrixNo'");
			if($result){
				$_SESSION['profilePic'] = $fPath;
				echo '<script>alert("Successfully edit profile");
							location = "profile.php";
					  </script>';
			}else{
				echo '<script>alert("Failed to edit profile.");</script>';
			}

		}
		echo '<script>alert("Failed to edit profile.");</script>';
		echo "<meta http-equiv='refresh' content='0'>";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Profile | Student | UReCo</title>
	<script src="../../js/studentprofile.js"></script>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_profile').addClass('active');
        });
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<div class="py-4">

		<div class="d-flex flex-column " id="content">
			<nav aria-label="breadcrumb">
			  	<ol class="breadcrumb" id="mapping">
			    	<li class="breadcrumb-item active" id="mapping1" aria-current="page">Profile</li>
			    	<li class="breadcrumb-item hidden" id="mapping2">Profile</li>
			    	<li class="breadcrumb-item active hidden" id="mapping3" aria-current="page">Edit Profile</li>
			  	</ol>
			</nav>			
			<form method="POST" action="profile.php" name="edit_profile" enctype="multipart/form-data">
				<div class="d-flex">
					<div class="p-2">
						<h3 id="heading1">My Profile</h3>
						<h3 class="hidden" id="heading2">Edit Profile</h3>
					</div>
					<div class="p-2">
						<button type="button" class="btn btn-primary" id="edit-btn">Edit</button>
						<button type="button" class="btn btn-primary" id="pswd-btn" onclick="location.href='changePassword.php'">Change password</button>
						<button type="submit" name="submit" class="hidden" id="save-btn" onclick="return confirm('Are you sure to save?');">Save</button>
						<button type="reset" class="hidden" id="back-btn" >Back</button>
					</div>
				</div>
				<?php
					$query=mysqli_query($conn, "SELECT * FROM student WHERE matrixNo='$matrixNo'");
					while($row=mysqli_fetch_array($query)){
				?>
				<div class="d-flex flex-wrap rounded p-4 bg-color">
					<div class="p-2">
						<img src="<?php echo htmlentities($row['profilePic']); ?>" class="profile-photo" id="profile-photo">
						<div class="photo-input hidden" id="photo-btn"> 
						 	<input type="file" id="file-input" name="file" class="form-control form-control-sm" accept="image/jpg, image/png" />
						 	<h4 class="btn btn-primary" onclick="document.getElementById('file-input').click()"> <i class="fa fa-camera" aria-hidden="true"></i></h4> 
						 </div>	 
					</div>
					<div class="p-2">
						<div class="mb-3">
							<label for="name" class="form-label fw-bold fs-5">Name</label>
							<input type="text" readonly class="form-control-plaintext" id="name" name="studName" value="<?php echo htmlentities($row['studName']);?>" required>
						</div>
						<div class="mb-3">
							<label for="matric_num" class="form-label fw-bold fs-5">Matric Number</label>
							<p id="matric_num" class="py-2"><?php echo htmlentities($row['matrixNo']);?></p>
						</div>
						<div class="mb-3">
							<label for="gender" class="form-label fw-bold fs-5">Gender</label>
							<select name="gender" disabled class="form-control-plaintext" id="gender" required>
								<option value="">Select Gender</option>
							<?php if($row['gender']=='1'){?>
								<option value="2">Female</option>
								<option value="1" selected>Male</option>
							<?php }else if($row['gender']=='2'){?>
								<option value="2" selected>Female</option>
								<option value="1">Male</option>
							<?php }?>
							</select>		
						</div>
						<div class="mb-3">
							<label for="email" class="form-label fw-bold fs-5">Email</label>
							<input type="email" name="studEmail" readonly class="form-control-plaintext" id="email" value="<?php echo htmlentities($row['studEmail']);?>" required>
						</div>
						<div class="mb-3">
							<label for="tel" class="form-label fw-bold fs-5">Tel</label>
							<input type="tel" pattern=[6]{1}[0]{1}[1]{1}[0-9]{8,9} title="Format: 601XXXXXXXX." name="studTel" readonly class="form-control-plaintext" id="tel" value="<?php echo htmlentities($row['studTel']);?>" required>
						</div>
					</div>
					<div class="p-2">
						<div class="mb-3">
							<label for="year" class="form-label fw-bold fs-5">Year</label>
							<input type="number"name="year"  readonly class="form-control-plaintext" id="year" value="<?php echo htmlentities($row['year']);?>" min="1" max="4"required>
						</div>
						<div class="mb-3">
							<label for="faculty" class="form-label fw-bold fs-5">Faculty</label>
							<select name="faculty" disabled class="form-control-plaintext" id="faculty" required>
								<option value="">Select Faculty</option>
								<?php if($row['faculty']=="FKE"){?>
								<option value="FKE" selected>FKE</option>
								<?php }else{?>
								<option value="FKE">FKE</option>
								<?php }if($row['faculty']=="FKEKK"){?>
								<option value="FKEKK" selected>FKEKK</option>
								<?php }else{?>
								<option value="FKEKK">FKEKK</option>
								<?php }if($row['faculty']=="FKM"){?>
								<option value="FKM" selected>FKM</option>
								<?php }else{?>
								<option value="FKM">FKM</option>
								<?php }if($row['faculty']=="FKP"){?>
								<option value="FKP" selected>FKP</option>
								<?php }else{?>
								<option value="FKP">FKP</option>
								<?php }if($row['faculty']=="FPTT"){?>
								<option value="FPTT" selected>FPTT</option>
								<?php }else{?>
								<option value="FPTT">FPTT</option>
								<?php }if($row['faculty']=="FTKEE"){?>
								<option value="FTKEE" selected>FTKEE</option>
								<?php }else{?>
								<option value="FTKEE">FTKEE</option>
								<?php }if($row['faculty']=="FTKMP"){?>
								<option value="FTKMP" selected>FTKMP</option>
								<?php }else{?>
								<option value="FTKMP">FTKMP</option>
								<?php }if($row['faculty']=="FTMK"){?>
								<option value="FTMK" selected>FTMK</option>
								<?php }else{?>
								<option value="FTMK">FTMK</option>
								<?php }?>
							</select>		
						</div>
					</div>
					<div class="p-2">
						<div class="mb-3">
							<label for="college" class="form-label fw-bold fs-5">College</label>
							<p id="college" class="py-2"><?php echo htmlentities($_SESSION['collegeID']) ;?> <?php echo htmlentities($_SESSION['collegeName']) ;?></p>
						</div>
						<div class="mb-3">
							<label for="block" class="form-label fw-bold fs-5">Block</label>
							<p id="block" class="py-2"><?php echo htmlentities($_SESSION['blockID']) ;?> <?php echo htmlentities($_SESSION['blockName']) ;?></p>
						</div>
						<div class="mb-3">
							<label for="room" class="form-label fw-bold fs-5">Room</label>
							<p id="room" class="py-2"><?php echo htmlentities($_SESSION['roomID']) ;?></p>
						</div>
					</div>
				</div>
				<?php }?>

			</form>
		</div>
	</div>
	<!--Container Main end-->

</body>
</html>