<?php
	include("auth.php");
	include("../config.php");
	if(isset($_GET['id'])){
			$sID = $_GET['id'];
		}
		else
			echo '<script>alert("Error!")</script>';
	
	$sqls = "SELECT maintenance.*, block.blockName FROM maintenance JOIN block ON maintenance.blockID = block.blockID WHERE maintID = '".$sID."'";
		$results = mysqli_query($conn, $sqls);
		$row = mysqli_fetch_assoc($results);
			$oldMaintID = $row['maintID'];
			$oldMaintName = $row['maintName'];
			$oldGender = $row['gender'];
			$oldCollege = $row['collegeID'];
			$oldBlock = $row['blockID'];
			$oldBlockName = $row['blockName'];
			$oldMaintTel = $row['maintTel'];
		
?>

<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Update Maintenance Team Member | Admin | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_user').addClass('active');
           $('#nav_user_maint').addClass('active');
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
			    	<li class="breadcrumb-item">Maintenance Team List</li>
			    	<li class="breadcrumb-item active" aria-current="page">Update New Maintenance Team Member</li>
			  	</ol>
			</nav>
			<div class="d-flex">
				<div class="p-2">
					<h3>Update New Maintenance Team Member</h3>
				</div>
				<div class="p-2">
					<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='userMaintList.php'">Back</button>
				</div>
			</div>
				
			<form action="userMaintUpdate.php?id=<?php echo $sID ?>" name="maint_update" method="POST">
				<div class="rounded p-4 mb-3 bg-color">
					<div class="p-2">
						<h3 >Personal Info</h3>
					</div>
					<div class="container">
						<div class="row mb-3">
							<label for="MTName" class="col-sm-2 form-label">MT Name</label>
							<div class="col-sm-8">
								<input required type="text" class="form-control" name="maint_name" id="MTName" placeholder="MT Name" value="<?php echo htmlentities($oldMaintName);?>">
							</div>
						</div>
						<div class="row mb-3">
							<label for="MTID" class="col-sm-2 form-label">MT ID</label>
							<div class="col-sm-3">
								<input required type="text" class="form-control" name="maint_id" id="MTID" placeholder="MT ID" value="<?php echo htmlentities($oldMaintID);?>">
							</div>
						</div>
						<div class="row mb-3">
							<label for="MTTel" class="col-sm-2 form-label">MT No. Tel</label>
							<div class="col-sm-3">
								<input required type="tel" pattern=[6]{1}[0]{1}[1]{1}[0-9]{8,9} title="Format: 601XXXXXXXX." class="form-control" name="maint_tel" id="MTTel" placeholder="MT No. Tel" value="<?php echo htmlentities($oldMaintTel);?>">
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
											if($row['collegeID'] == $oldCollege){
												echo '<option value="'.$row['collegeID'].'" selected>'.$row['collegeName'].'</option>';
											}
											else{
												echo '<option value="'.$row['collegeID'].'">'.$row['collegeName'].'</option>';
											}
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

				<input type="submit" name="submit" class="btn btn-primary" id="submit-btn" value="Submit">
				<input type="reset" name="reset" class="btn btn-primary" id="reset-btn" value="Reset">
			</form>	
		</div><!-- content -->
	</div><!-- py-4 -->
	<!--Container Main end-->
<?php
		
		
		$sqls = "SELECT * FROM maintenance WHERE maintID = '".$sID."'";
		$results = mysqli_query($conn, $sqls);
		$check = mysqli_num_rows($results);
		$row = mysqli_fetch_assoc($results);
		if($check > 0){
			$oldMaintID = $row['maintID'];
			$oldMaintName = $row['maintName'];
			$oldGender = $row['gender'];
			$oldCollege = $row['collegeID'];
			$oldBlock = $row['blockID'];
			$oldMaintTel = $row['maintTel'];
		}
		else
			echo '<script>alert("USER NOT FOUND!")</script>';
		
		if(isset($_POST['submit'])){
				$maint_id = $_POST['maint_id'];
				$maint_name 	= $_POST['maint_name'];
				$maint_tel 	= $_POST['maint_tel'];
				$gender 	= $_POST['gender'];
				$college 	= $_POST['college_id'];
				$block 		= $_POST['block_id'];
				
				if(empty($maint_id))
					$maint_id = $oldMaintID;
				if(empty($maint_name))
					$maint_name = $oldMaintName;
				if(empty($maint_tel))
					$maint_tel = $oldMaintTel;
				if(empty($gender))
					$gender = $oldGender;
				if(empty($college))
					$college = $oldCollege;
				if(empty($block))
					$block = $oldBlock;
				
				$sqlu = "UPDATE maintenance SET maintID='".$maint_id."', maintName='".$maint_name."', gender='".$gender."', maintTel='".$maint_tel."',  blockID='".$block."', collegeID='".$college."' WHERE maintID = '".$sID."'";
				if(mysqli_query($conn, $sqlu)){
					echo "<script>alert('Record updated successfully')
							location = 'userMaintList.php'
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