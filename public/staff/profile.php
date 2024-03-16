<?php
	include("auth.php");
	include("../config.php");
	$staffID=$_SESSION['staff_id'];
	
	if (isset($_POST['submit'])) {
		$staffName=$_POST['staffName'];
		$gender=$_POST['gender'];
		$staffTel=$_POST['staffTel'];
		$staffEmail=$_POST['staffEmail'];
		$file = $_FILES['file']['name'];
		
		if($file == "")
			$fPath = $_SESSION['profilePic'];
		else{
			
			$path = "../uploaded_files/profile/".$staffID;
			if (!file_exists($path)) {
				mkdir($path);
			}
				
			$upload_file = date("YmdHis").'_'.$_FILES['file']['name'];// correct file & filename into db
			$fPath = $path.'/'.$upload_file;
			move_uploaded_file($_FILES["file"]["tmp_name"], $path.'/'.$upload_file); //current file, datetime_name into $path
		}

		if($staffName!=""&&$gender!=""&&$staffTel!=""&&$staffEmail!=""&&$fPath!=""){
				
			$result = mysqli_query($conn,"UPDATE staff SET staffName='$staffName', gender='$gender', staffTel='$staffTel', staffEmail='$staffEmail', profilePic='$fPath' WHERE staffID='$staffID'");
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
	<title>Profile | Staff | UReCo</title>
	<script src="../../js/staffprofile.js"></script>

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
					$query=mysqli_query($conn, "SELECT * FROM staff WHERE staffID='$staffID'");
					while($row=mysqli_fetch_array($query)){
				?>
				<div class="d-flex flex-wrap rounded p-4 bg-color">
					<div class="p-2">
						<img src="<?php echo htmlentities($row['profilePic'])?>" class="profile-photo" id="profile-photo">
						<div class="photo-input hidden" id="photo-btn"> 
						 	<input type="file" name="file" id="file-input" class="form-control form-control-sm" accept="image/png, image/jpg" />
						 	<h4 class="btn btn-primary" onclick="document.getElementById('file-input').click()"> <i class="fa fa-camera" aria-hidden="true"></i></h4> 
						 </div>	 
					</div>
					<div class="p-2">
						<div class="mb-3">
							<label for="name" class="form-label fw-bold fs-5">Name</label>
							<input type="text" readonly class="form-control-plaintext" id="name" name="staffName" value="<?php echo htmlentities($row['staffName']);?>" required>
						</div>
						<div class="mb-3">
							<label for="matric_num" class="form-label fw-bold fs-5">Staff ID</label>
							<p id="matric_num" class="py-2"><?php echo htmlentities($row['staffID']);?></p>
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
							<input type="email" name="staffEmail" readonly class="form-control-plaintext" id="email" value="<?php echo htmlentities($row['staffEmail']);?>" required>
						</div>
						<div class="mb-3">
							<label for="tel" class="form-label fw-bold fs-5">Tel</label>
							<input type="tel" name="staffTel" pattern=[6]{1}[0]{1}[1]{1}[0-9]{8,9} title="Format: 601XXXXXXXX." readonly class="form-control-plaintext" id="tel" value="<?php echo htmlentities($row['staffTel']);?>" required>
						</div>
					</div>
					<div class="p-2">
						<div class="mb-3">
							<label for="college" class="form-label fw-bold fs-5">College</label>
							<p id="college" class="py-2"><?php echo htmlentities($_SESSION['college_id']) ;?> <?php echo htmlentities($_SESSION['college_name']) ;?></p>
						</div>
						<div class="mb-3">
							<label for="block" class="form-label fw-bold fs-5">Block</label>
							<p id="block" class="py-2"><?php echo htmlentities($_SESSION['block_id']) ;?> <?php echo htmlentities($_SESSION['block_name']) ;?></p>
						</div>
					</div>
				</div>
	          <?php } ?>
				
			</form>
		</div>
	</div>
	<!--Container Main end-->

</body>
</html>