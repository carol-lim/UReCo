<?php
	include("auth.php");
	include("../config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Facility List | Admin | UReCo</title>

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
			    	<li class="breadcrumb-item ">Facility</li>
			    	<li class="breadcrumb-item active" aria-current="page">Facility List</li>
			  	</ol>
			</nav>
			<div class="d-flex">
				<div class="p-2">
					<h3>Facility List</h3>
				</div>
				<div class="p-2">
					<button type="button" class="btn btn-primary" id="add-btn" onclick="location.href='facilityAdd.php'">Add New Facility</button>
				</div>
			</div>
			<div class="d-flex flex-wrap rounded p-4 bg-color">
				<div class="table-responsive">  
					<table id="facility" class="table table-striped table-bordered dt-responsive wrap" style="width:100%">  
						<thead>  
							<tr>  
								<th scope="col">#</th>
								<th scope="col">Facility ID</th>
								<th scope="col">Name</th>
								<th scope="col">College</th>
								<th scope="col">Update</th>
								<th scope="col">Delete</th>
							</tr>  
						</thead>
						<tbody>  
						<?php
							$query = mysqli_query($conn, "SELECT facilityID, facilityName, college.collegeName FROM facility JOIN college ON facility.collegeID=college.collegeID"); 
							if(mysqli_num_rows($query)>0){
								$i=0;
								while($row = mysqli_fetch_array($query)){  
								$i=$i+1;
									?>
				                    <tr>
										<td><?php echo $i;?></td>
										<td><?php echo htmlentities($row['facilityID']);?></td>
										<td><?php echo htmlentities($row['facilityName']);?></td>
										<td><?php echo htmlentities($row['collegeName']);?></td>
										<td><input type="button" name="update" class="btn btn-warning" value="Update" onclick="location.href='facilityUpdate.php?id=<?php echo $row['facilityID']; ?>'"></td>
										<td><input type="button" name="delete" class="btn btn-warning" value="Delete" onclick="DeleteFacility('<?php echo $row['facilityID']; ?>')"></td>
				                    </tr>
							<?php
				            	}
				            }else{
				          ?>
				            <tr>
				              <td colspan="6" align="center">No Facility.</td>
				            </tr>
				          <?php } ?>
			            </tbody>
					</table>  
				</div> 
			</div>
		</div>
	</div>
	<!-- datatable js -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>  
	<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>  
	<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>            
	<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
	<!-- datatable css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap4.css" />
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />  
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css"/>    
	<script>  
		$(document).ready(function() {
	    $('#facility').DataTable();
	} );
	function DeleteFacility(id){
			if(confirm('Are you sure?')){
				location = 'facilityDelete.php?id='+id;
			}
			else{
				alert(id);
			}
		}
	</script>  
	<!--Container Main end-->

</body>
</html>