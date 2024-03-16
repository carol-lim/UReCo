<?php
	include("auth.php");
	include("../config.php");
	$matrixNo = $_SESSION['matrixNo'];
?>

<!DOCTYPE html>
<html>
<head>
	<?php include("head.html");?>
	<title>Closed Helpdesk | Student | UReCo</title>
	<script src="../../js/studentprofile.js"></script>

	<script type="text/javascript">
        $(document).ready(function($){
           // tell sidebar to active current navlink
           $('#nav_hd').addClass('active');
           $('#nav_hd_closed').addClass('active');
        });
    </script>
</head>
<body id="body-pd">
	<?php include("sidebar.html");?>
	<div class="py-4">

		<div class="d-flex flex-column " id="content">
			<nav aria-label="">
			  	<ol class="breadcrumb">
			    	<li class="breadcrumb-item">Maintenance Helpdesk</li>
			    	<li class="breadcrumb-item active" aria-current="page">Closed Helpdesk</li>
			  	</ol>
			</nav>			
			<div class="d-flex">
				<div class="p-2">
					<h3 id="heading1">Closed Helpdesk</h3>
				</div>
			</div>
				
			<div class="rounded p-4 bg-color">
				<div class="table-responsive">  
					<table id="helpdesk_closed" class="table table-striped table-bordered dt-responsive wrap" style="width:100%">  
						<thead>  
							<tr>  
								<td>Service Referral Number</td>  
								<td>Category</td>  
								<td>Subcategory</td>
								<td>Open at</td>
								<td>Closed at</td>
								<td>Days used</td>
								<td>Status</td>
							</tr>  
						</thead>
						<tbody>  
						<?php  
						$query = mysqli_query($conn, "SELECT helpdesk.*, category.categoryName, subcategory.scName FROM helpdesk JOIN category ON helpdesk.category = category.categoryID JOIN subcategory ON helpdesk.subcategory = subcategory.scID WHERE matrixNo ='$matrixNo' AND closeDate IS NOT NULL"); 
						if(mysqli_num_rows($query)>0){
							while($row = mysqli_fetch_array($query)){  
								?>
			                    <tr>
									<td><a href="helpdeskDetail.php?hdid=<?php echo $row['hdID']?>&status=closed"><?php echo htmlentities($row['hdID']);?></a></td>
									<td><?php echo htmlentities($row['categoryName']);?></td>
									<td><?php echo htmlentities($row['scName']);?></td>
									<td><?php echo htmlentities($row['openDate']);?></td>
									<td><?php echo htmlentities($row['closeDate']);?></td>
									<td><?php echo htmlentities($row['daysUsed']);?></td>
									<td>
										<?php  
										$hdid = $row['hdID'];
										$result = mysqli_query($conn, "SELECT statusName FROM helpdesktracker WHERE hdtID = '$hdid' ORDER BY creationDate DESC LIMIT 1"); 
										$roww 	= mysqli_fetch_assoc($result);
										if ($roww==""){
											echo htmlentities('none');	
										}
										else {
											echo htmlentities($roww['statusName']);
										}?>
										
									</td>
	                    </tr>
						<?php
			            	}} ?>
			            </tbody>
					</table>  
				</div>
			</div>
		</div>
	</div>
	<!--Container Main end-->
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
	    $('#helpdesk_closed').DataTable();
	} );
</script>  
</body>
</html>