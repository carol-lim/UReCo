<?php
	include("auth.php");
	include("../config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Add Staff | Admin | UReCo</title>

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
			    	<li class="breadcrumb-item active" aria-current="page">Add New Staff</li>
			  	</ol>
			</nav>
			<div class="d-flex">
				<div class="p-2">
					<h3>Add New Staff</h3>
				</div>
				<div class="p-2">
					<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='userStaffList.php'">Back</button>
				</div>
			</div>
				
			<form action="userStaffAdd.php" name="staff_add" method="POST">
				<div class="rounded p-4 mb-3 bg-color">
					<div class="p-2">
						<h3 >Personal Info</h3>
					</div>
					<div class="container">
						<div class="row mb-3">
							<label for="StaffName" class="col-sm-2 form-label">Staff Name</label>
							<div class="col-sm-8">
								<input required type="text" class="form-control" name="staff_name" id="StaffName" placeholder="Staff Name">
							</div>
						</div>
						<div class="row mb-3">
							<label for="StaffID" class="col-sm-2 form-label">Staff ID</label>
							<div class="col-sm-3">
								<input required type="text" pattern=[S]{1}[0-9]{4} title="Must start with S and 4 numbers." class="form-control" name="staff_id" id="StaffID" placeholder="Staff ID">
							</div>
						</div>
						<div class="row mb-3">
							<label for="StaffTelephone" class="col-sm-2 form-label">Staff No. Tel</label>
							<div class="col-sm-3">
								<input required type="tel" pattern=[6]{1}[0]{1}[1]{1}[0-9]{8,9} title="Format: 601XXXXXXXX." class="form-control" name="staff_tel" id="StaffTel" placeholder="Staff No. Tel">
							</div>
						</div>
						<div class="row mb-3">
							<label for="Gender" class="col-sm-2 form-label">Gender</label>
							<div class="col-sm-3">
								<select required class="form-control" name="gender" id="Gender">
									<option>Select Gender</option>
									<option value="2">Female</option>
									<option value="1">Male</option>
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
									<option>Select college first</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="rounded p-4 mb-3 bg-color">
					<div class="p-2">
						<h3 >Set Email & Password</h3>
					</div>
					<div class="container">
						<div class="row mb-3">
							<label for="StaffEmail" class="col-sm-2 form-label">Email Address</label>
							<div class="col-sm-4">
								<input required type="text" class="form-control" name="staff_email" id="StaffEmail" placeholder="Email Address">
							</div>
						</div>
						<div class="row mb-3">
							<label for="Password" class="col-sm-2 form-label">Password</label>
							<div class="col-sm-4">
								<input required type="password" class="form-control" name="staff_pass" id="Password" placeholder="Password">
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
		if (isset($_POST['submit'])){
			$sql = "INSERT INTO staff(staffID, staffName, gender, staffTel, blockID, collegeID, staffEmail)
					VALUES ('".$_POST['staff_id']."', '".$_POST['staff_name']."', '".$_POST['gender']."', '".$_POST['staff_tel']."', '".$_POST['block_id']."', '".$_POST['college_id']."', '".$_POST['staff_email']."')";
			$result = mysqli_query($conn, $sql);
			if(!$result)
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			else{
				$sql2 = "INSERT INTO user (username, password, accType) VALUES ('".$_POST['staff_id']."', '".md5($_POST['staff_pass'])."','2')";
				$result2 = mysqli_query($conn, $sql2);
				if(!$result2)
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				else{
					echo "<script> alert('Staff record successfully added');
							location = 'userstaffList.php';</script>";
					exit();
				}
			}
			mysqli_close($conn);
		}
		
	?>
</body>
</html>