<?php 
	require_once 'auth.php';
	include("../config.php");
?>
<!DOCTYPE html>
<html>
<head>
	<?php 
		include("head.html");
		// require_once 'auth_admin.php';
	?>
	<title>Search Staff | Staff | UReCo</title>
	
	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_search').addClass('active');
           $('#nav_search_staff').addClass('active');
        });
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<div class="py-4">
		<div class="d-flex flex-column " id="content">
			<nav aria-label="breadcrumb">
			  	<ol class="breadcrumb">
			    	<li class="breadcrumb-item ">User</li>
			    	<li class="breadcrumb-item active" aria-current="page">Staff List</li>
			  	</ol>
			</nav>
			<div class="d-flex">
				<div class="p-2">
					<h3>Staff List</h3>
				</div>
			</div>
				
			<div class="d-flex flex-wrap rounded p-4 bg-color">
				<div class="table-responsive">  
					<table id="staff" class="table table-striped table-bordered dt-responsive wrap" style="width:100%">  
						<thead>  
							<tr>  
								<th scope="col">#</th>
								<th scope="col">Staff ID</th>
								<th scope="col">Name</th>
								<th scope="col">Gender</th>
								<th scope="col">Contact</th>
								<th scope="col">Email</th>
								<th scope="col">College</th>
								<th scope="col">Block</th>
							</tr>  
						</thead>
						<tbody>  
						<?php
							$query = mysqli_query($conn, "SELECT staffID, staffName, gender, staffEmail, staffTel, block.blockName, college.collegeName FROM staff JOIN block ON block.blockID=staff.blockID JOIN college ON block.collegeID=college.collegeID"); 
				if(mysqli_num_rows($query)>0){
					$i=0;
					while($row = mysqli_fetch_array($query)){  
					$i=$i+1;
						?>
	                    <tr>
							<td><?php echo $i;?></td>
							<td><?php echo htmlentities($row['staffID']);?></td>
							<td><?php echo htmlentities($row['staffName']);?></td>
							<td><?php if($row['gender'] == 1)
										echo htmlentities('M');
									else
										echo htmlentities('F');?></td>
							<td><?php echo htmlentities($row['staffTel']);?></td>
							<td><?php echo htmlentities($row['staffEmail']);?></td>
							<td><?php echo htmlentities($row['collegeName']);?></td>
							<td><?php echo htmlentities($row['blockName']);?></td>
	                    </tr>
				<?php
	            	}
	            }?>
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
		    $('#staff').DataTable();
		} );
		
	</script>  
	<!--Container Main end-->

</body>
</html>