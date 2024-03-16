<?php
	include("auth.php");
	include("../config.php");
	if(isset($_GET['id'])){
		$sID = $_GET['id'];
	}
	else
		echo '<script>alert("Error!")</script>';
	
	$sqls = "SELECT staff.*, block.blockName FROM staff JOIN block ON staff.blockID = block.blockID WHERE staffID = '".$sID."'";
		$results = mysqli_query($conn, $sqls);
		$check = mysqli_num_rows($results);
		$row = mysqli_fetch_assoc($results);
		if($check > 0){
			$oldStaffID = $row['staffID'];
			$oldStaffName = $row['staffName'];
			$oldGender = $row['gender'];
			$oldCollege = $row['collegeID'];
			$oldBlock = $row['blockID'];
			$oldBlockName = $row['blockName'];
			$oldStaffTel = $row['staffTel'];
		}
		else
			echo '<script>alert("USER NOT FOUND!")</script>';

?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Update Staff | Admin | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_user').addClass('active');
           $('#nav_user_staff').addClass('active');
        });
        function FetchBlock(id){
		$('#Block').html('');
		$('#Room').html('');
			$.ajax({
			  type:'post',
			  url: 'ajaxdata.php',
			  data : { college_id : id},
			  success : function(data){
				 $('#Block').html(data);
			  }

			})
		}
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<div class="py-4">
		<div class="d-flex flex-column " id="content">
			<nav aria-label="breadcrumb">
			  	<ol class="breadcrumb">
			    	<li class="breadcrumb-item">User</li>
			    	<li class="breadcrumb-item">Staff List</li>
			    	<li class="breadcrumb-item active" aria-current="page">Update Staff</li>
			  	</ol>
			</nav>
			<div class="d-flex">
				<div class="p-2">
					<h3>Update Staff</h3>
				</div>
				<div class="p-2">
					<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='userStaffList.php'">Back</button>
				</div>
			</div>
				
			<form action="userStaffUpdate.php?id=<?php echo $sID ?>" name="staff_update" method="POST">
				<div class="rounded p-4 mb-3 bg-color">
					<div class="p-2">
						<h3 >Personal Info</h3>
					</div>
					<div class="container">
						<div class="row mb-3">
							<label for="StaffName" class="col-sm-2 form-label">Staff Name</label>
							<div class="col-sm-8">
								<input required type="text" class="form-control" name="staff_name" id="StaffName" placeholder="Staff Name" value="<?php echo htmlentities($oldStaffName); ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label for="StaffID" class="col-sm-2 form-label">Staff ID</label>
							<div class="col-sm-3">
								<input required type="text" class="form-control" name="staff_id" id="StaffID" placeholder="Staff ID" value="<?php echo htmlentities($oldStaffID); ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label for="StaffTelephone" class="col-sm-2 form-label">Staff No. Tel</label>
							<div class="col-sm-3">
								<input required type="tel" pattern=[6]{1}[0]{1}[1]{1}[0-9]{8,9} title="Format: 601XXXXXXXX." class="form-control" name="staff_tel" id="StaffTel" placeholder="Staff No. Tel" value="<?php echo htmlentities($oldStaffTel); ?>">
							</div>
						</div>
						<div class="row mb-3">
							<label for="Gender" class="col-sm-2 form-label">Gender</label>
							<div class="col-sm-3">
								<select required class="form-control" name="gender" id="Gender">
									<?php	if($oldGender == 1){?>
									<option value="">Select Gender</option>
									<option value="2">Female</option>
									<option value="1" selected>Male</option>
								<?php	}
										else{?>
									<option value="">Select Gender</option>
									<option value="2" selected>Female</option>
									<option value="1">Male</option>
								<?php	} ?>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="rounded p-4 mb-3 bg-color">
					<div class="p-2">
						<h3 >College Info</h3>
					</div>
					<div class="container">
						<div class="row mb-3">
							<?php
								$sql = "SELECT collegeID, collegeName FROM college";
								$result = mysqli_query($conn, $sql);
							?>
							<label for="College" class="col-sm-2 form-label">College</label>
							<div class="col-sm-4">
								<select required class="form-control" name="college_id" id="College" onchange="FetchBlock(this.value)">
									<option>Select College</option>
									<?php 
										while($row = mysqli_fetch_assoc($result)){
											if($row['collegeID'] == $oldCollege)
												echo '<option value="'.$row['collegeID'].'" selected>'.$row['collegeName'].'</option>';
											else
												echo '<option value="'.$row['collegeID'].'">'.$row['collegeName'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label for="Block" class="col-sm-2 form-label">Block</label>
							<div class="col-sm-4">
								<select required class="form-control" name="block_id" id="Block">
									<option value="<?php echo htmlentities($oldBlock); ?>"><?php echo htmlentities($oldBlockName); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<input type="submit" name="submit" class="btn btn-primary" id="submit-btn" value="Update">
				<input type="reset" name="reset" class="btn btn-primary" id="reset-btn" value="Reset">
			</form>	
		</div><!-- content -->
	</div><!-- py-4 -->
	<!--Container Main end-->
<?php
		
		
		
		
		if(isset($_POST['submit'])){
				$staff_id = $_POST['staff_id'];
				$staff_name 	= $_POST['staff_name'];
				$staff_tel 	= $_POST['staff_tel'];
				$gender 	= $_POST['gender'];
				$college 	= $_POST['college_id'];
				$block 		= $_POST['block_id'];
				
				if(empty($staff_id))
					$staff_id = $oldStaffID;
				if(empty($staff_name))
					$staff_name = $oldStaffName;
				if(empty($staff_tel))
					$staff_tel = $oldStaffTel;
				if(empty($gender))
					$gender = $oldGender;
				if(empty($college))
					$college = $oldCollege;
				if(empty($block))
					$block = $oldBlock;
				
				$sqlu = "UPDATE staff SET staffID='".$staff_id."', staffName='".$staff_name."', gender='".$gender."', staffTel='".$staff_tel."',  blockID='".$block."', collegeID='".$college."' WHERE staffID = '".$sID."'";
				if(mysqli_query($conn, $sqlu)){
					echo "<script>alert('Record updated successfully')
							location = 'userStaffList.php'
							</script>";
					exit();
				} 
				else {
				  echo "Error updating record: " . mysqli_error($conn);
				}

				mysqli_close($conn);
		}
		
	?>
</body>
</html>