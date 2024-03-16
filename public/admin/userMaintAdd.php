<?php
	include("auth.php");
	include("../config.php");
?>

<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Add Maintenance Team Member | Admin | UReCo</title>

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
			    	<li class="breadcrumb-item active" aria-current="page">Add New Maintenance Team Member</li>
			  	</ol>
			</nav>
			<div class="d-flex">
				<div class="p-2">
					<h3>Add New Maintenance Team Member</h3>
				</div>
				<div class="p-2">
					<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='userMaintList.php'">Back</button>
				</div>
			</div>
				
			<form action="userMaintAdd.php" name="maint_add" method="POST">
				<div class="rounded p-4 mb-3 bg-color">
					<div class="p-2">
						<h3 >Personal Info</h3>
					</div>
					<div class="container">
						<div class="row mb-3">
							<label for="MTName" class="col-sm-2 form-label">MT Name</label>
							<div class="col-sm-8">
								<input required type="text" class="form-control" name="maint_name" id="MTName" placeholder="MT Name">
							</div>
						</div>
						<div class="row mb-3">
							<label for="MTID" class="col-sm-2 form-label">MT ID</label>
							<div class="col-sm-3">
								<input required pattern=[M]{1}[0-9]{4} title="Must start with M and 4 numbers." type="text" class="form-control" name="maint_id" id="MTID" placeholder="MT ID">
							</div>
						</div>
						<div class="row mb-3">
							<label for="MTTel" class="col-sm-2 form-label">MT No. Tel</label>
							<div class="col-sm-3">
								<input required pattern=[6]{1}[0]{1}[1]{1}[0-9]{8,9} title="Format: 601XXXXXXXX." type="text" class="form-control" name="maint_tel" id="MTTel" placeholder="MT No. Tel">
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
							<label for="MTEmail" class="col-sm-2 form-label">Email Address</label>
							<div class="col-sm-4">
								<input required type="email" class="form-control" name="maint_email" id="MTEmail" placeholder="Email Address">
							</div>
						</div>
						<div class="row mb-3">
							<label for="MTPass" class="col-sm-2 form-label">Password</label>
							<div class="col-sm-4">
								<input required type="password" class="form-control" name="maint_pass" id="MTPass" placeholder="Password">
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
			$sql = "INSERT INTO maintenance(maintID, maintName, gender, maintTel, blockID, collegeID, maintEmail)
					VALUES ('".$_POST['maint_id']."', '".$_POST['maint_name']."', '".$_POST['gender']."', '".$_POST['maint_tel']."', '".$_POST['block_id']."', '".$_POST['college_id']."', '".$_POST['maint_email']."')";
			$result = mysqli_query($conn, $sql);
			if(!$result)
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			else{
				$sql2 = "INSERT INTO user (username, password, accType) VALUES ('".$_POST['maint_id']."', '".md5($_POST['maint_pass'])."','3')";
				$result2 = mysqli_query($conn, $sql2);
				if(!$result2)
					echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
				else{
					echo "<script> alert('MT record successfully added');
							location = 'userMaintList.php';</script>";
					exit();
				}
			}
			mysqli_close($conn);
		}
	?>
</body>
</html>

