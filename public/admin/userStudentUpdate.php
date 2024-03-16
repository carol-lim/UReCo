<?php
	include("auth.php");
	include("../config.php");
	
	$matrixNum = $_GET['matrixNo'];	
	$sqls = "SELECT student.*, block.blockName FROM student JOIN block on student.blockID = block.blockID WHERE matrixNo = '".$matrixNum."'";
		$results = mysqli_query($conn, $sqls);
		$check = mysqli_num_rows($results);
		$row = mysqli_fetch_assoc($results);
		if($check > 0){
			$oldMatrixNo = $row['matrixNo'];
			$oldStudName = $row['studName'];
			$oldGender = $row['gender'];
			$oldYear = $row['year'];
			$oldFaculty = $row['faculty'];
			$oldCollege = $row['collegeID'];
			$oldBlock = $row['blockID'];
			$oldBlockName = $row['blockName'];
			$oldRoom = $row['roomID'];
			$oldStudTel = $row['studTel'];
		}
		else
			echo '<script>alert("USER NOT FOUND!")</script>';
		
	?>
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Update Student | Admin | UReCo</title>

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
			    	<li class="breadcrumb-item active" aria-current="page">Update Student</li>
			  	</ol>
			</nav>
			<div class="d-flex">
				<div class="p-2">
					<h3 >Update Student</h3>
				</div>
				<div class="p-2">
					<form action="userStudentUpdate.php?matrixNo=<?php echo $matrixNum ?>" name="stud_search" method="POST">
						<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='userStudentSearch.php'">Back</button>
					</form>
				</div>
			</div>
				
			<form action="userStudentUpdate.php?matrixNo=<?php echo $matrixNum ?>" name="stud_search" method="POST">
				<div class="rounded p-4 mb-3 bg-color">
					<div class="p-2">
						<h3 >Personal Info</h3>
					</div>
					<div class="container">
						<div class="row mb-3">
							<label for="StudentName" class="col-sm-2 form-label">Student Name</label>
							<div class="col-sm-8">
								<input required type="text" class="form-control" name="stud_name" id="StudentName" placeholder="Student Name" value="<?php echo htmlentities($oldStudName);?>">
							</div>
						</div>
						<div class="row mb-3">
							<label for="MatricNumber" class="col-sm-2 form-label">Matric Number</label>
							<div class="col-sm-2">
								<input required type="text" class="form-control" name="matric_num" id="MatricNumber" placeholder="Matric Number" value="<?php echo htmlentities($oldMatrixNo);?>" disabled>
							</div>
						</div>
						<div class="row mb-3">
							<label for="StudentTel" class="col-sm-2 form-label">Student No. Tel</label>
							<div class="col-sm-2">
								<input required type="tel" pattern=[6]{1}[0]{1}[1]{1}[0-9]{8,9} title="Format: 601XXXXXXXX." class="form-control" name="stud_tel" id="StudentTel" placeholder="Student No. Tel" value="<?php echo htmlentities($oldStudTel);?>">
							</div>
						</div>
						<div class="row mb-3">
							<label for="Gender" class="col-sm-2 form-label">Gender</label>
							<div class="col-sm-2">
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
						<div class="row mb-3">
							<label for="Year" class="col-sm-2 form-label">Year</label>
							<div class="col-sm-2">
								<select required class="form-control" name="year" id="Year">
								<?php	if($oldYear == 1){?>
									<option value="">Select Year</option>
									<option value="1" selected>1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								<?php	}
										else if($oldYear == 2){?>
									<option value="">Select Year</option>
									<option value="1">1</option>
									<option value="2" selected>2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								<?php	}
										else if($oldYear == 3){?>
									<option value="">Select Year</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3" selected>3</option>
									<option value="4">4</option>
									<?php	}
										else{?>
									<option value="">Select Year</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4" selected>4</option>
								<?php	} ?>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label for="Faculty" class="col-sm-2 form-label">Faculty</label>
							<div class="col-sm-2">
								<select required class="form-control" name="faculty" id="Faculty">
								<?php	if($oldFaculty == "FKE"){?>
									<option value="">Select Faculty</option>
									<option value="FKE" selected>FKE</option>
									<option value="FKEKK">FKEKK</option>
									<option value="FKM">FKM</option>
									<option value="FKP">FKP</option>
									<option value="FPTT">FPTT</option>
									<option value="FTKEE">FTKEE</option>
									<option value="FTKMP">FTKMP</option>
									<option value="FTMK">FTMK</option>
								<?php	}
										else if($oldFaculty == "FKEKK"){?>
									<option value="">Select Faculty</option>
									<option value="FKE">FKE</option>
									<option value="FKEKK" selected>FKEKK</option>
									<option value="FKM">FKM</option>
									<option value="FKP">FKP</option>
									<option value="FPTT">FPTT</option>
									<option value="FTKEE">FTKEE</option>
									<option value="FTKMP">FTKMP</option>
									<option value="FTMK">FTMK</option>
								<?php	}
										else if($oldFaculty == "FKM"){?>
									<option value="">Select Faculty</option>
									<option value="FKE">FKE</option>
									<option value="FKEKK">FKEKK</option>
									<option value="FKM" selected>FKM</option>
									<option value="FKP">FKP</option>
									<option value="FPTT">FPTT</option>
									<option value="FTKEE">FTKEE</option>
									<option value="FTKMP">FTKMP</option>
									<option value="FTMK">FTMK</option>
								<?php	}
										else if($oldFaculty == "FKP"){?>
									<option value="">Select Faculty</option>
									<option value="FKE">FKE</option>
									<option value="FKEKK">FKEKK</option>
									<option value="FKM">FKM</option>
									<option value="FKP" selected>FKP</option>
									<option value="FPTT">FPTT</option>
									<option value="FTKEE">FTKEE</option>
									<option value="FTKMP">FTKMP</option>
									<option value="FTMK">FTMK</option>
								<?php	}
										else if($oldFaculty == "FPTT"){?>
									<option value="">Select Faculty</option>
									<option value="FKE">FKE</option>
									<option value="FKEKK">FKEKK</option>
									<option value="FKM">FKM</option>
									<option value="FKP">FKP</option>
									<option value="FPTT" selected>FPTT</option>
									<option value="FTKEE">FTKEE</option>
									<option value="FTKMP">FTKMP</option>
									<option value="FTMK">FTMK</option>
								<?php	}
										else if($oldFaculty == "FTKEE"){?>
									<option value="">Select Faculty</option>
									<option value="FKE">FKE</option>
									<option value="FKEKK">FKEKK</option>
									<option value="FKM">FKM</option>
									<option value="FKP">FKP</option>
									<option value="FPTT">FPTT</option>
									<option value="FTKEE" selected>FTKEE</option>
									<option value="FTKMP">FTKMP</option>
									<option value="FTMK">FTMK</option>
								<?php	}
										else if($oldFaculty == "FTKMP"){?>
									<option value="">Select Faculty</option>
									<option value="FKE">FKE</option>
									<option value="FKEKK">FKEKK</option>
									<option value="FKM">FKM</option>
									<option value="FKP">FKP</option>
									<option value="FPTT">FPTT</option>
									<option value="FTKEE">FTKEE</option>
									<option value="FTKMP" selected>FTKMP</option>
									<option value="FTMK">FTMK</option>
								<?php	}
										else if($oldFaculty == "FTMK"){?>
									<option value="">Select Faculty</option>
									<option value="FKE">FKE</option>
									<option value="FKEKK">FKEKK</option>
									<option value="FKM">FKM</option>
									<option value="FKP">FKP</option>
									<option value="FPTT">FPTT</option>
									<option value="FTKEE">FTKEE</option>
									<option value="FTKMP">FTKMP</option>
									<option value="FTMK" selected>FTMK</option>
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
									<option value="">Select College</option>
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
							<div class="col-sm-2">
								<select required class="form-control" name="block" id="Block" onchange="FetchRoom(this.value)">
									<option value="<?php echo htmlentities($oldBlock);?>"><?php echo htmlentities($oldBlockName);?></option>
								</select>
							</div>
						</div>	
						<div class="row mb-3">
							<label for="Room" class="col-sm-2 form-label">Room</label>
							<div class="col-sm-2">
								<select required class="form-control" name="room" id="Room">
									<option value="<?php echo htmlentities($oldRoom);?>"><?php echo htmlentities($oldRoom);?></option>
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
		
		
		
		
		if(isset($_POST['submit'])){
				$matric_num = $_POST['matric_num'];
				$stud_name 	= $_POST['stud_name'];
				$stud_tel 	= $_POST['stud_tel'];
				$gender 	= $_POST['gender'];
				$year 		= $_POST['year'];
				$faculty 	= $_POST['faculty'];
				$college 	= $_POST['college_id'];
				$block 		= $_POST['block_id'];
				$room 		= $_POST['room'];
				
				if(empty($matric_num))
					$matric_num = $oldMatrixNo;
				if(empty($stud_name))
					$stud_name = $oldStudName;
				if(empty($stud_tel))
					$stud_tel = $oldStudTel;
				if(empty($gender))
					$gender = $oldGender;
				if(empty($year))
					$year = $oldYear;
				if(empty($faculty))
					$faculty = $oldFaculty;
				if(empty($college))
					$college = $oldCollege;
				if(empty($block))
					$block = $oldBlock;
				if(empty($room))
					$room = $oldRoom;
				
				$sqlu = "UPDATE student SET matrixNo='".$matric_num."', studName='".$stud_name."', gender='".$gender."', faculty='".$faculty."', year='".$year."', studTel='".$stud_tel."', roomID='".$room."', blockID='".$block."', collegeID='".$college."' WHERE matrixNo = '".$matrixNum."'";
				if(mysqli_query($conn, $sqlu)){
					echo "<script>alert('Record updated successfully')
							location = 'userStudentSearch.php'
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