<?php
	include("auth.php");
	include("../config.php");
	if(isset($_GET['id'])){
			$sID = $_GET['id'];
	}
	else
		echo '<script>alert("Error!")</script>';
	
	$sqls = "SELECT * FROM facility WHERE facilityID = '".$sID."'";
		$results = mysqli_query($conn, $sqls);
		$check = mysqli_num_rows($results);
		$row = mysqli_fetch_assoc($results);
		if($check > 0){
			$oldFacilityID = $row['facilityID'];
			$oldFacilityName = $row['facilityName'];
			$oldCollege = $row['collegeID'];
		}
		else
			echo '<script>alert("USER NOT FOUND!")</script>';
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Update New Facility | Admin | UReCo</title>

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
			    	<li class="breadcrumb-item active" aria-current="page">Update New Facility</li>
			  	</ol>
			</nav>
			<div class="d-flex">
				<div class="p-2">
					<h3>Update New Facility</h3>
				</div>
				<div class="p-2">
					<button type="reset" class="btn btn-primary" id="back-btn" onclick="location.href='facilityList.php'">Back</button>
				</div>
			</div>
				
			<form action="facilityUpdate.php?id=<?php echo $sID ?>" name="facility_update" method="POST">
				<div class="rounded p-4 mb-3 bg-color">
					<div class="p-2">
						<h3 >Facility Info</h3>
					</div>
					<div class="container">
						<div class="row mb-3">
							<label for="FacilityName" class="col-sm-2 form-label">Facility Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="facility_name" id="FacilityName" placeholder="Facility Name" value="<?php echo htmlentities($oldFacilityName);?>">
							</div>
						</div>
						<div class="row mb-3">
							<label for="FacilityID" class="col-sm-2 form-label">Facility ID</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" name="facility_id" id="FacilityID" placeholder="Facility ID" value="<?php echo htmlentities($oldFacilityID);?>">
							</div>
						</div>
						
						<div class="row mb-3">
							<?php
								$sql = "SELECT collegeID, collegeName FROM college";
								$result = mysqli_query($conn, $sql);
							?>
							<label for="College" class="col-sm-2 form-label">College</label>
							<div class="col-sm-4">
								<select class="form-control" name="college_id" id="College" onchange="FetchBlock(this.value)">
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
					</div>
				</div>
				<input type="submit" name="submit" class="btn btn-primary" id="submit-btn" value="Submit">
				<input type="reset" name="reset" class="btn btn-primary" id="reset-btn" value="Reset">
			</form>	
		</div><!-- content -->
	</div>
	<!--Container Main end-->
<?php
		
		
		
		
		if(isset($_POST['submit'])){
				$facility_id = $_POST['facility_id'];
				$facility_name 	= $_POST['facility_name'];
				$college 	= $_POST['college_id'];
				
				if(empty($facility_id))
					$facility_id = $oldFacilityID;
				if(empty($facility_name))
					$facility_name = $oldFacilityName;
				if(empty($college))
					$college = $oldCollege;
				
				$sqlu = "UPDATE facility SET facilityID='".$facility_id."', facilityName='".$facility_name."', collegeID='".$college."' WHERE facilityID = '".$sID."'";
				if(mysqli_query($conn, $sqlu)){
					echo "<script>alert('Record updated successfully')
							location = 'facilityList.php'
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