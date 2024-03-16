<?php
	include("auth.php");
	include("../config.php");
?>

<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Add Student | Admin | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_user').addClass('active');
           $('#nav_user_stud').addClass('active');
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
		function FetchRoom(id){
		$('#Room').html('');
			$.ajax({
			  type:'post',
			  url: 'ajaxdata.php',
			  data : { block_id : id},
			  success : function(data){
				 $('#Room').html(data);
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
			    	<li class="breadcrumb-item">Search Student</li>
			    	<li class="breadcrumb-item active" aria-current="page">Add New Student</li>
			  	</ol>
			</nav>
			<div class="d-flex">
				<div class="p-2">
					<h3>Add New Student</h3>
				</div>
				<div class="p-2">
					<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='userStudentSearch.php'">Back</button>
				</div>
			</div>
				
			<form action="userStudentAdd.php" name="stud_search" method="POST">
				<div class="rounded p-4 mb-3 bg-color">
					<div class="p-2">
						<h3 >Personal Info</h3>
					</div>
					<div class="container">
						<div class="row mb-3">
							<label for="StudentName" class="col-sm-2 form-label">Student Name</label>
							<div class="col-sm-8">
								<input required type="text" class="form-control" name="stud_name" id="StudentName" placeholder="Student Name">
							</div>
						</div>
						<div class="row mb-3">
							<label for="MatricNumber" class="col-sm-2 form-label">Matric Number</label>
							<div class="col-sm-3">
								<input required type="text" class="form-control" name="matric_num" id="MatricNumber" placeholder="Matric Number">
							</div>
						</div>
						<div class="row mb-3">
							<label for="StudentTel" class="col-sm-2 form-label">Student No. Tel</label>
							<div class="col-sm-3">
								<input required type="tel" pattern=[6]{1}[0]{1}[1]{1}[0-9]{8,9} title="Format: 601XXXXXXXX." class="form-control" name="stud_tel" id="StudentTel" placeholder="Student No. Tel">
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
						<div class="row mb-3">
							<label for="Year" class="col-sm-2 form-label">Year</label>
							<div class="col-sm-3">
								<select required class="form-control" name="year" id="Year">
									<option>Select Year</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label for="Faculty" class="col-sm-2 form-label">Faculty</label>
							<div class="col-sm-3">
								<select required class="form-control" name="faculty" id="Faculty">
									<option>Select Faculty</option>
									<option value="FKE">FKE</option>
									<option value="FKEKK">FKEKK</option>
									<option value="FKM">FKM</option>
									<option value="FKP">FKP</option>
									<option value="FPTT">FPTT</option>
									<option value="FTKEE">FTKEE</option>
									<option value="FTKMP">FTKMP</option>
									<option value="FTMK">FTMK</option>
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
								include("../config.php");
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
							<div class="col-sm-3">
								<select required class="form-control" name="block_id" id="Block" onchange="FetchRoom(this.value)">
									<option>Select Block</option>
								</select>
							</div>
						</div>

						<div class="row mb-3">
							<label for="Room" class="col-sm-2 form-label">Room</label>
							<div class="col-sm-3">
								<select required class="form-control" name="room" id="Room">
									<option>Select Room</option>
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
							<label for="StudentEmail" class="col-sm-2 form-label">Email Address</label>
							<div class="col-sm-4">
								<input required type="text" class="form-control" name="stud_email" id="StudentEmail" placeholder="Email Address">
							</div>
						</div>
						<div class="row mb-3">
							<label for="Password" class="col-sm-2 form-label">Password</label>
							<div class="col-sm-4">
								<input required type="password" class="form-control" name="stud_pass" id="Password" placeholder="Password">
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
			$sql = "INSERT INTO student(matrixNo, studName, gender, faculty, year, studTel, roomID, blockID, collegeID, studEmail)
					VALUES ('".$_POST['matric_num']."', '".$_POST['stud_name']."', '".$_POST['gender']."', '".$_POST['faculty']."', '".$_POST['year']."', '".$_POST['stud_tel']."', '".$_POST['room']."', '".$_POST['block_id']."', '".$_POST['college_id']."', '".$_POST['stud_email']."')";
			$result = mysqli_query($conn, $sql);
			if(!$result)
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			else{
				$sql2 = "INSERT INTO user (username, password, accType) VALUES ('".$_POST['matric_num']."', '".md5($_POST['stud_pass'])."','1')";
				$result2 = mysqli_query($conn, $sql2);
				if(!$result2)
					echo "Error: " . $sql . "<br>" . mysqli_error($conn);
				else{
					echo "<script> alert('Student record successfully added');
							location = 'userStudentSearch.php';</script>";
					exit();
				}
			}
			mysqli_close($conn);
		}
		
	?>
</body>
</html>