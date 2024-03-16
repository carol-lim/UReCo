<?php
	include("auth.php");
	include("../config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Add New Facility | Admin | UReCo</title>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_facility').addClass('active');
        });
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<div class="pt-4">
		<div class="d-flex flex-column " id="content">
			<nav aria-label="breadcrumb">
			  	<ol class="breadcrumb">
			    	<li class="breadcrumb-item">Facility</li>
			    	<li class="breadcrumb-item active" aria-current="page">Add New Facility</li>
			  	</ol>
			</nav>
			<div class="d-flex">
				<div class="p-2">
					<h3>Add New Facility</h3>
				</div>
				<div class="p-2">
					<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='facilityList.php'">Back</button>
				</div>
			</div>
				
			<form action="facilityAdd.php" name="facility_add" method="POST">
				<div class="rounded p-4 mb-3 bg-color">
					<div class="p-2">
						<h3 >Facility Info</h3>
					</div>
					<div class="container">
						<div class="row mb-3">
							<label for="FacilityName" class="col-sm-2 form-label">Facility Name</label>
							<div class="col-sm-8">
								<input required type="text" class="form-control" name="facility_name" id="FacilityName" placeholder="Facility Name">
							</div>
						</div>
						<div class="row mb-3">
							<label for="FacilityID" class="col-sm-2 form-label">Facility ID</label>
							<div class="col-sm-3">
								<input required type="text" class="form-control" name="facility_id" id="FacilityID" placeholder="Facility ID">
							</div>
						</div>
						
						<div class="row mb-3">
							<?php
								$sql = "SELECT collegeID, collegeName FROM college";
								$result = mysqli_query($conn, $sql);
							?>
							<label for="College" class="col-sm-2 form-label">College</label>
							<div class="col-sm-4">
								<select required class="form-control" name="college_id" id="College">
									<option>Select College</option>
									<?php 
										while($row = mysqli_fetch_assoc($result)){
											echo '<option value="'.$row['collegeID'].'">'.$row['collegeName'].'</option>';
										}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<input type="submit" name="submit" class="btn btn-primary" id="submit-btn" value="Submit">
				<input type="reset" name="reset" class="btn btn-primary" id="reset-btn" value="Reset">
			</form>	
		</div><!-- content -->
	</div>
	<!--Container Main end-->
<?php
		if (isset($_POST['submit'])){
			$sql = "INSERT INTO facility(facilityID, facilityName, collegeID) VALUES ('".$_POST['facility_id']."', '".$_POST['facility_name']."', '".$_POST['college_id']."')";
			$result = mysqli_query($conn, $sql);
			if(!$result)
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			else{
				echo "<script> alert('Facility record successfully added');
						location = 'facilityList.php';</script>";
				exit();
				}
			mysqli_close($conn);
		}
		
	?>
</body>
</html>